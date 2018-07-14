<?php

// Global variable for table object
$t_pendaftaran = NULL;

//
// Table class for t_pendaftaran
//
class ct_pendaftaran extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $IDXDAFTAR;
	var $PASIENBARU;
	var $NOMR;
	var $TGLREG;
	var $KDDOKTER;
	var $KDPOLY;
	var $KDRUJUK;
	var $KDCARABAYAR;
	var $NOJAMINAN;
	var $SHIFT;
	var $STATUS;
	var $KETERANGAN_STATUS;
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
	var $TOTAL_BIAYA_OBAT;
	var $biaya_obat;
	var $biaya_retur_obat;
	var $TOTAL_BIAYA_OBAT_RAJAL;
	var $biaya_obat_rajal;
	var $biaya_retur_obat_rajal;
	var $TOTAL_BIAYA_OBAT_IGD;
	var $biaya_obat_igd;
	var $biaya_retur_obat_igd;
	var $TOTAL_BIAYA_OBAT_IBS;
	var $biaya_obat_ibs;
	var $biaya_retur_obat_ibs;
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
	var $cek_data_kepesertaan;
	var $generate_sep;
	var $PESERTANIK_SEP;
	var $PESERTANAMA_SEP;
	var $PESERTAJENISKELAMIN_SEP;
	var $PESERTANAMAKELAS_SEP;
	var $PESERTAPISAT;
	var $PESERTATGLLAHIR;
	var $PESERTAJENISPESERTA_SEP;
	var $PESERTANAMAJENISPESERTA_SEP;
	var $PESERTATGLCETAKKARTU_SEP;
	var $POLITUJUAN_SEP;
	var $NAMAPOLITUJUAN_SEP;
	var $KDPPKRUJUKAN_SEP;
	var $NMPPKRUJUKAN_SEP;
	var $UPDATETGLPLNG_SEP;
	var $bridging_upt_tglplng;
	var $mapingtransaksi;
	var $bridging_no_rujukan;
	var $bridging_hapus_sep;
	var $bridging_kepesertaan_by_no_ka;
	var $NOKARTU_BPJS;
	var $counter_cetak_kartu;
	var $bridging_kepesertaan_by_nik;
	var $NOKTP;
	var $bridging_by_no_rujukan;
	var $maping_hapus_sep;
	var $counter_cetak_kartu_ranap;
	var $BIAYA_PENDAFTARAN;
	var $BIAYA_TINDAKAN_POLI;
	var $BIAYA_TINDAKAN_RADIOLOGI;
	var $BIAYA_TINDAKAN_LABORAT;
	var $BIAYA_TINDAKAN_KONSULTASI;
	var $BIAYA_TARIF_DOKTER;
	var $BIAYA_TARIF_DOKTER_KONSUL;
	var $INCLUDE;
	var $eklaim_kelas_rawat_rajal;
	var $eklaim_adl_score;
	var $eklaim_adl_sub_acute;
	var $eklaim_adl_chronic;
	var $eklaim_icu_indikator;
	var $eklaim_icu_los;
	var $eklaim_ventilator_hour;
	var $eklaim_upgrade_class_ind;
	var $eklaim_upgrade_class_class;
	var $eklaim_upgrade_class_los;
	var $eklaim_birth_weight;
	var $eklaim_discharge_status;
	var $eklaim_diagnosa;
	var $eklaim_procedure;
	var $eklaim_tarif_rs;
	var $eklaim_tarif_poli_eks;
	var $eklaim_id_dokter;
	var $eklaim_nama_dokter;
	var $eklaim_kode_tarif;
	var $eklaim_payor_id;
	var $eklaim_payor_cd;
	var $eklaim_coder_nik;
	var $eklaim_los;
	var $eklaim_patient_id;
	var $eklaim_admission_id;
	var $eklaim_hospital_admission_id;
	var $bridging_hapussep;
	var $user_penghapus_sep;
	var $BIAYA_BILLING_RAJAL;
	var $STATUS_PEMBAYARAN;
	var $BIAYA_TINDAKAN_FISIOTERAPI;
	var $eklaim_reg_pasien;
	var $eklaim_reg_klaim_baru;
	var $eklaim_gruper1;
	var $eklaim_gruper2;
	var $eklaim_finalklaim;
	var $eklaim_sendklaim;
	var $eklaim_flag_hapus_pasien;
	var $eklaim_flag_hapus_klaim;
	var $eklaim_kemkes_dc_Status;
	var $eklaim_bpjs_dc_Status;
	var $eklaim_cbg_code;
	var $eklaim_cbg_descprition;
	var $eklaim_cbg_tariff;
	var $eklaim_sub_acute_code;
	var $eklaim_sub_acute_deskripsi;
	var $eklaim_sub_acute_tariff;
	var $eklaim_chronic_code;
	var $eklaim_chronic_deskripsi;
	var $eklaim_chronic_tariff;
	var $eklaim_inacbg_version;
	var $BIAYA_TINDAKAN_IBS_RAJAL;
	var $VERIFY_ICD;
	var $bridging_rujukan_faskes_2;
	var $eklaim_reedit_claim;
	var $KETERANGAN;
	var $TGLLAHIR;
	var $USER_KASIR;
	var $eklaim_tgl_gruping;
	var $eklaim_tgl_finalklaim;
	var $eklaim_tgl_kirim_klaim;
	var $BIAYA_OBAT_RS;
	var $EKG_RAJAL;
	var $USG_RAJAL;
	var $FISIOTERAPI_RAJAL;
	var $BHP_RAJAL;
	var $BIAYA_TINDAKAN_ASKEP_IBS_RAJAL;
	var $BIAYA_TINDAKAN_TMNO_IBS_RAJAL;
	var $TOTAL_BIAYA_IBS_RAJAL;
	var $ORDER_LAB;
	var $BILL_RAJAL_SELESAI;
	var $INCLUDE_IDXDAFTAR;
	var $INCLUDE_HARGA;
	var $TARIF_JASA_SARANA;
	var $TARIF_PENUNJANG_NON_MEDIS;
	var $TARIF_ASUHAN_KEPERAWATAN;
	var $KDDOKTER_RAJAL;
	var $KDDOKTER_KONSUL_RAJAL;
	var $BIAYA_BILLING_RS;
	var $BIAYA_TINDAKAN_POLI_TMO;
	var $BIAYA_TINDAKAN_POLI_KEPERAWATAN;
	var $BHP_RAJAL_TMO;
	var $BHP_RAJAL_KEPERAWATAN;
	var $TARIF_AKOMODASI;
	var $TARIF_AMBULAN;
	var $TARIF_OKSIGEN;
	var $BIAYA_TINDAKAN_JENAZAH;
	var $BIAYA_BILLING_IGD;
	var $BIAYA_TINDAKAN_POLI_PERSALINAN;
	var $BHP_RAJAL_PERSALINAN;
	var $TARIF_BIMBINGAN_ROHANI;
	var $BIAYA_BILLING_RS2;
	var $BIAYA_TARIF_DOKTER_IGD;
	var $BIAYA_PENDAFTARAN_IGD;
	var $BIAYA_BILLING_IBS;
	var $TARIF_JASA_SARANA_IGD;
	var $BIAYA_TARIF_DOKTER_SPESIALIS_IGD;
	var $BIAYA_TARIF_DOKTER_KONSUL_IGD;
	var $TARIF_MAKAN_IGD;
	var $TARIF_ASUHAN_KEPERAWATAN_IGD;
	var $pasien_TITLE;
	var $pasien_NAMA;
	var $pasien_TEMPAT;
	var $pasien_TGLLAHIR;
	var $pasien_JENISKELAMIN;
	var $pasien_ALAMAT;
	var $pasien_KELURAHAN;
	var $pasien_KDKECAMATAN;
	var $pasien_KOTA;
	var $pasien_KDPROVINSI;
	var $pasien_NOTELP;
	var $pasien_NOKTP;
	var $pasien_SUAMI_ORTU;
	var $pasien_PEKERJAAN;
	var $pasien_AGAMA;
	var $pasien_PENDIDIKAN;
	var $pasien_ALAMAT_KTP;
	var $pasien_NO_KARTU;
	var $pasien_JNS_PASIEN;
	var $pasien_nama_ayah;
	var $pasien_nama_ibu;
	var $pasien_nama_suami;
	var $pasien_nama_istri;
	var $pasien_KD_ETNIS;
	var $pasien_KD_BHS_HARIAN;
	var $BILL_FARMASI_SELESAI;
	var $TARIF_PELAYANAN_SIMRS;
	var $USER_ADM;
	var $TARIF_PENUNJANG_NON_MEDIS_IGD;
	var $TARIF_PELAYANAN_DARAH;
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
		$this->TableVar = 't_pendaftaran';
		$this->TableName = 't_pendaftaran';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_pendaftaran`";
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
		$this->IDXDAFTAR = new cField('t_pendaftaran', 't_pendaftaran', 'x_IDXDAFTAR', 'IDXDAFTAR', '`IDXDAFTAR`', '`IDXDAFTAR`', 3, -1, FALSE, '`IDXDAFTAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->IDXDAFTAR->Sortable = FALSE; // Allow sort
		$this->IDXDAFTAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IDXDAFTAR'] = &$this->IDXDAFTAR;

		// PASIENBARU
		$this->PASIENBARU = new cField('t_pendaftaran', 't_pendaftaran', 'x_PASIENBARU', 'PASIENBARU', '`PASIENBARU`', '`PASIENBARU`', 3, -1, FALSE, '`PASIENBARU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->PASIENBARU->Sortable = FALSE; // Allow sort
		$this->PASIENBARU->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->PASIENBARU->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->PASIENBARU->OptionCount = 2;
		$this->PASIENBARU->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['PASIENBARU'] = &$this->PASIENBARU;

		// NOMR
		$this->NOMR = new cField('t_pendaftaran', 't_pendaftaran', 'x_NOMR', 'NOMR', '`NOMR`', '`NOMR`', 200, -1, FALSE, '`NOMR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOMR->Sortable = FALSE; // Allow sort
		$this->fields['NOMR'] = &$this->NOMR;

		// TGLREG
		$this->TGLREG = new cField('t_pendaftaran', 't_pendaftaran', 'x_TGLREG', 'TGLREG', '`TGLREG`', ew_CastDateFieldForLike('`TGLREG`', 7, "DB"), 133, 7, FALSE, '`TGLREG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TGLREG->Sortable = FALSE; // Allow sort
		$this->TGLREG->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['TGLREG'] = &$this->TGLREG;

		// KDDOKTER
		$this->KDDOKTER = new cField('t_pendaftaran', 't_pendaftaran', 'x_KDDOKTER', 'KDDOKTER', '`KDDOKTER`', '`KDDOKTER`', 3, -1, FALSE, '`KDDOKTER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDDOKTER->Sortable = FALSE; // Allow sort
		$this->KDDOKTER->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDDOKTER->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDDOKTER->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDDOKTER'] = &$this->KDDOKTER;

		// KDPOLY
		$this->KDPOLY = new cField('t_pendaftaran', 't_pendaftaran', 'x_KDPOLY', 'KDPOLY', '`KDPOLY`', '`KDPOLY`', 3, -1, FALSE, '`KDPOLY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDPOLY->Sortable = FALSE; // Allow sort
		$this->KDPOLY->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDPOLY->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDPOLY->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDPOLY'] = &$this->KDPOLY;

		// KDRUJUK
		$this->KDRUJUK = new cField('t_pendaftaran', 't_pendaftaran', 'x_KDRUJUK', 'KDRUJUK', '`KDRUJUK`', '`KDRUJUK`', 3, -1, FALSE, '`KDRUJUK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDRUJUK->Sortable = FALSE; // Allow sort
		$this->KDRUJUK->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDRUJUK->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDRUJUK->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDRUJUK'] = &$this->KDRUJUK;

		// KDCARABAYAR
		$this->KDCARABAYAR = new cField('t_pendaftaran', 't_pendaftaran', 'x_KDCARABAYAR', 'KDCARABAYAR', '`KDCARABAYAR`', '`KDCARABAYAR`', 3, -1, FALSE, '`KDCARABAYAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDCARABAYAR->Sortable = FALSE; // Allow sort
		$this->KDCARABAYAR->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDCARABAYAR->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDCARABAYAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDCARABAYAR'] = &$this->KDCARABAYAR;

		// NOJAMINAN
		$this->NOJAMINAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_NOJAMINAN', 'NOJAMINAN', '`NOJAMINAN`', '`NOJAMINAN`', 200, -1, FALSE, '`NOJAMINAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOJAMINAN->Sortable = FALSE; // Allow sort
		$this->fields['NOJAMINAN'] = &$this->NOJAMINAN;

		// SHIFT
		$this->SHIFT = new cField('t_pendaftaran', 't_pendaftaran', 'x_SHIFT', 'SHIFT', '`SHIFT`', '`SHIFT`', 3, -1, FALSE, '`SHIFT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->SHIFT->Sortable = FALSE; // Allow sort
		$this->SHIFT->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['SHIFT'] = &$this->SHIFT;

		// STATUS
		$this->STATUS = new cField('t_pendaftaran', 't_pendaftaran', 'x_STATUS', 'STATUS', '`STATUS`', '`STATUS`', 3, -1, FALSE, '`STATUS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->STATUS->Sortable = FALSE; // Allow sort
		$this->STATUS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['STATUS'] = &$this->STATUS;

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS = new cField('t_pendaftaran', 't_pendaftaran', 'x_KETERANGAN_STATUS', 'KETERANGAN_STATUS', '`KETERANGAN_STATUS`', '`KETERANGAN_STATUS`', 2, -1, FALSE, '`KETERANGAN_STATUS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETERANGAN_STATUS->Sortable = FALSE; // Allow sort
		$this->KETERANGAN_STATUS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KETERANGAN_STATUS'] = &$this->KETERANGAN_STATUS;

		// NIP
		$this->NIP = new cField('t_pendaftaran', 't_pendaftaran', 'x_NIP', 'NIP', '`NIP`', '`NIP`', 200, -1, FALSE, '`NIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIP->Sortable = FALSE; // Allow sort
		$this->fields['NIP'] = &$this->NIP;

		// MASUKPOLY
		$this->MASUKPOLY = new cField('t_pendaftaran', 't_pendaftaran', 'x_MASUKPOLY', 'MASUKPOLY', '`MASUKPOLY`', ew_CastDateFieldForLike('`MASUKPOLY`', 4, "DB"), 134, 4, FALSE, '`MASUKPOLY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MASUKPOLY->Sortable = FALSE; // Allow sort
		$this->MASUKPOLY->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_TIME_SEPARATOR"], $Language->Phrase("IncorrectTime"));
		$this->fields['MASUKPOLY'] = &$this->MASUKPOLY;

		// KELUARPOLY
		$this->KELUARPOLY = new cField('t_pendaftaran', 't_pendaftaran', 'x_KELUARPOLY', 'KELUARPOLY', '`KELUARPOLY`', ew_CastDateFieldForLike('`KELUARPOLY`', 4, "DB"), 134, 4, FALSE, '`KELUARPOLY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KELUARPOLY->Sortable = FALSE; // Allow sort
		$this->KELUARPOLY->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_TIME_SEPARATOR"], $Language->Phrase("IncorrectTime"));
		$this->fields['KELUARPOLY'] = &$this->KELUARPOLY;

		// KETRUJUK
		$this->KETRUJUK = new cField('t_pendaftaran', 't_pendaftaran', 'x_KETRUJUK', 'KETRUJUK', '`KETRUJUK`', '`KETRUJUK`', 200, -1, FALSE, '`KETRUJUK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETRUJUK->Sortable = FALSE; // Allow sort
		$this->fields['KETRUJUK'] = &$this->KETRUJUK;

		// KETBAYAR
		$this->KETBAYAR = new cField('t_pendaftaran', 't_pendaftaran', 'x_KETBAYAR', 'KETBAYAR', '`KETBAYAR`', '`KETBAYAR`', 200, -1, FALSE, '`KETBAYAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETBAYAR->Sortable = FALSE; // Allow sort
		$this->fields['KETBAYAR'] = &$this->KETBAYAR;

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA = new cField('t_pendaftaran', 't_pendaftaran', 'x_PENANGGUNGJAWAB_NAMA', 'PENANGGUNGJAWAB_NAMA', '`PENANGGUNGJAWAB_NAMA`', '`PENANGGUNGJAWAB_NAMA`', 200, -1, FALSE, '`PENANGGUNGJAWAB_NAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_NAMA->Sortable = FALSE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_NAMA'] = &$this->PENANGGUNGJAWAB_NAMA;

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_PENANGGUNGJAWAB_HUBUNGAN', 'PENANGGUNGJAWAB_HUBUNGAN', '`PENANGGUNGJAWAB_HUBUNGAN`', '`PENANGGUNGJAWAB_HUBUNGAN`', 200, -1, FALSE, '`PENANGGUNGJAWAB_HUBUNGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_HUBUNGAN->Sortable = FALSE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_HUBUNGAN'] = &$this->PENANGGUNGJAWAB_HUBUNGAN;

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT = new cField('t_pendaftaran', 't_pendaftaran', 'x_PENANGGUNGJAWAB_ALAMAT', 'PENANGGUNGJAWAB_ALAMAT', '`PENANGGUNGJAWAB_ALAMAT`', '`PENANGGUNGJAWAB_ALAMAT`', 200, -1, FALSE, '`PENANGGUNGJAWAB_ALAMAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_ALAMAT->Sortable = FALSE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_ALAMAT'] = &$this->PENANGGUNGJAWAB_ALAMAT;

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE = new cField('t_pendaftaran', 't_pendaftaran', 'x_PENANGGUNGJAWAB_PHONE', 'PENANGGUNGJAWAB_PHONE', '`PENANGGUNGJAWAB_PHONE`', '`PENANGGUNGJAWAB_PHONE`', 200, -1, FALSE, '`PENANGGUNGJAWAB_PHONE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_PHONE->Sortable = FALSE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_PHONE'] = &$this->PENANGGUNGJAWAB_PHONE;

		// JAMREG
		$this->JAMREG = new cField('t_pendaftaran', 't_pendaftaran', 'x_JAMREG', 'JAMREG', '`JAMREG`', ew_CastDateFieldForLike('`JAMREG`', 0, "DB"), 135, 0, FALSE, '`JAMREG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JAMREG->Sortable = FALSE; // Allow sort
		$this->JAMREG->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['JAMREG'] = &$this->JAMREG;

		// BATAL
		$this->BATAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_BATAL', 'BATAL', '`BATAL`', '`BATAL`', 200, -1, FALSE, '`BATAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BATAL->Sortable = FALSE; // Allow sort
		$this->fields['BATAL'] = &$this->BATAL;

		// NO_SJP
		$this->NO_SJP = new cField('t_pendaftaran', 't_pendaftaran', 'x_NO_SJP', 'NO_SJP', '`NO_SJP`', '`NO_SJP`', 200, -1, FALSE, '`NO_SJP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_SJP->Sortable = FALSE; // Allow sort
		$this->fields['NO_SJP'] = &$this->NO_SJP;

		// NO_PESERTA
		$this->NO_PESERTA = new cField('t_pendaftaran', 't_pendaftaran', 'x_NO_PESERTA', 'NO_PESERTA', '`NO_PESERTA`', '`NO_PESERTA`', 200, -1, FALSE, '`NO_PESERTA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_PESERTA->Sortable = FALSE; // Allow sort
		$this->fields['NO_PESERTA'] = &$this->NO_PESERTA;

		// NOKARTU
		$this->NOKARTU = new cField('t_pendaftaran', 't_pendaftaran', 'x_NOKARTU', 'NOKARTU', '`NOKARTU`', '`NOKARTU`', 200, -1, FALSE, '`NOKARTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOKARTU->Sortable = FALSE; // Allow sort
		$this->fields['NOKARTU'] = &$this->NOKARTU;

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT = new cField('t_pendaftaran', 't_pendaftaran', 'x_TOTAL_BIAYA_OBAT', 'TOTAL_BIAYA_OBAT', '`TOTAL_BIAYA_OBAT`', '`TOTAL_BIAYA_OBAT`', 5, -1, FALSE, '`TOTAL_BIAYA_OBAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_BIAYA_OBAT->Sortable = FALSE; // Allow sort
		$this->TOTAL_BIAYA_OBAT->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOTAL_BIAYA_OBAT'] = &$this->TOTAL_BIAYA_OBAT;

		// biaya_obat
		$this->biaya_obat = new cField('t_pendaftaran', 't_pendaftaran', 'x_biaya_obat', 'biaya_obat', '`biaya_obat`', '`biaya_obat`', 5, -1, FALSE, '`biaya_obat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_obat->Sortable = FALSE; // Allow sort
		$this->biaya_obat->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_obat'] = &$this->biaya_obat;

		// biaya_retur_obat
		$this->biaya_retur_obat = new cField('t_pendaftaran', 't_pendaftaran', 'x_biaya_retur_obat', 'biaya_retur_obat', '`biaya_retur_obat`', '`biaya_retur_obat`', 5, -1, FALSE, '`biaya_retur_obat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_retur_obat->Sortable = FALSE; // Allow sort
		$this->biaya_retur_obat->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_retur_obat'] = &$this->biaya_retur_obat;

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_TOTAL_BIAYA_OBAT_RAJAL', 'TOTAL_BIAYA_OBAT_RAJAL', '`TOTAL_BIAYA_OBAT_RAJAL`', '`TOTAL_BIAYA_OBAT_RAJAL`', 5, -1, FALSE, '`TOTAL_BIAYA_OBAT_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_BIAYA_OBAT_RAJAL->Sortable = FALSE; // Allow sort
		$this->TOTAL_BIAYA_OBAT_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOTAL_BIAYA_OBAT_RAJAL'] = &$this->TOTAL_BIAYA_OBAT_RAJAL;

		// biaya_obat_rajal
		$this->biaya_obat_rajal = new cField('t_pendaftaran', 't_pendaftaran', 'x_biaya_obat_rajal', 'biaya_obat_rajal', '`biaya_obat_rajal`', '`biaya_obat_rajal`', 5, -1, FALSE, '`biaya_obat_rajal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_obat_rajal->Sortable = FALSE; // Allow sort
		$this->biaya_obat_rajal->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_obat_rajal'] = &$this->biaya_obat_rajal;

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal = new cField('t_pendaftaran', 't_pendaftaran', 'x_biaya_retur_obat_rajal', 'biaya_retur_obat_rajal', '`biaya_retur_obat_rajal`', '`biaya_retur_obat_rajal`', 5, -1, FALSE, '`biaya_retur_obat_rajal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_retur_obat_rajal->Sortable = FALSE; // Allow sort
		$this->biaya_retur_obat_rajal->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_retur_obat_rajal'] = &$this->biaya_retur_obat_rajal;

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_TOTAL_BIAYA_OBAT_IGD', 'TOTAL_BIAYA_OBAT_IGD', '`TOTAL_BIAYA_OBAT_IGD`', '`TOTAL_BIAYA_OBAT_IGD`', 5, -1, FALSE, '`TOTAL_BIAYA_OBAT_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_BIAYA_OBAT_IGD->Sortable = FALSE; // Allow sort
		$this->TOTAL_BIAYA_OBAT_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOTAL_BIAYA_OBAT_IGD'] = &$this->TOTAL_BIAYA_OBAT_IGD;

		// biaya_obat_igd
		$this->biaya_obat_igd = new cField('t_pendaftaran', 't_pendaftaran', 'x_biaya_obat_igd', 'biaya_obat_igd', '`biaya_obat_igd`', '`biaya_obat_igd`', 5, -1, FALSE, '`biaya_obat_igd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_obat_igd->Sortable = FALSE; // Allow sort
		$this->biaya_obat_igd->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_obat_igd'] = &$this->biaya_obat_igd;

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd = new cField('t_pendaftaran', 't_pendaftaran', 'x_biaya_retur_obat_igd', 'biaya_retur_obat_igd', '`biaya_retur_obat_igd`', '`biaya_retur_obat_igd`', 5, -1, FALSE, '`biaya_retur_obat_igd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_retur_obat_igd->Sortable = FALSE; // Allow sort
		$this->biaya_retur_obat_igd->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_retur_obat_igd'] = &$this->biaya_retur_obat_igd;

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS = new cField('t_pendaftaran', 't_pendaftaran', 'x_TOTAL_BIAYA_OBAT_IBS', 'TOTAL_BIAYA_OBAT_IBS', '`TOTAL_BIAYA_OBAT_IBS`', '`TOTAL_BIAYA_OBAT_IBS`', 5, -1, FALSE, '`TOTAL_BIAYA_OBAT_IBS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_BIAYA_OBAT_IBS->Sortable = FALSE; // Allow sort
		$this->TOTAL_BIAYA_OBAT_IBS->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOTAL_BIAYA_OBAT_IBS'] = &$this->TOTAL_BIAYA_OBAT_IBS;

		// biaya_obat_ibs
		$this->biaya_obat_ibs = new cField('t_pendaftaran', 't_pendaftaran', 'x_biaya_obat_ibs', 'biaya_obat_ibs', '`biaya_obat_ibs`', '`biaya_obat_ibs`', 5, -1, FALSE, '`biaya_obat_ibs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_obat_ibs->Sortable = FALSE; // Allow sort
		$this->biaya_obat_ibs->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_obat_ibs'] = &$this->biaya_obat_ibs;

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs = new cField('t_pendaftaran', 't_pendaftaran', 'x_biaya_retur_obat_ibs', 'biaya_retur_obat_ibs', '`biaya_retur_obat_ibs`', '`biaya_retur_obat_ibs`', 5, -1, FALSE, '`biaya_retur_obat_ibs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_retur_obat_ibs->Sortable = FALSE; // Allow sort
		$this->biaya_retur_obat_ibs->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_retur_obat_ibs'] = &$this->biaya_retur_obat_ibs;

		// TANGGAL_SEP
		$this->TANGGAL_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_TANGGAL_SEP', 'TANGGAL_SEP', '`TANGGAL_SEP`', ew_CastDateFieldForLike('`TANGGAL_SEP`', 0, "DB"), 135, 0, FALSE, '`TANGGAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TANGGAL_SEP->Sortable = FALSE; // Allow sort
		$this->TANGGAL_SEP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TANGGAL_SEP'] = &$this->TANGGAL_SEP;

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_TANGGALRUJUK_SEP', 'TANGGALRUJUK_SEP', '`TANGGALRUJUK_SEP`', ew_CastDateFieldForLike('`TANGGALRUJUK_SEP`', 0, "DB"), 135, 0, FALSE, '`TANGGALRUJUK_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TANGGALRUJUK_SEP->Sortable = FALSE; // Allow sort
		$this->TANGGALRUJUK_SEP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TANGGALRUJUK_SEP'] = &$this->TANGGALRUJUK_SEP;

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_KELASRAWAT_SEP', 'KELASRAWAT_SEP', '`KELASRAWAT_SEP`', '`KELASRAWAT_SEP`', 3, -1, FALSE, '`KELASRAWAT_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KELASRAWAT_SEP->Sortable = FALSE; // Allow sort
		$this->KELASRAWAT_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KELASRAWAT_SEP'] = &$this->KELASRAWAT_SEP;

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_MINTA_RUJUKAN', 'MINTA_RUJUKAN', '`MINTA_RUJUKAN`', '`MINTA_RUJUKAN`', 200, -1, FALSE, '`MINTA_RUJUKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->MINTA_RUJUKAN->Sortable = FALSE; // Allow sort
		$this->MINTA_RUJUKAN->OptionCount = 1;
		$this->fields['MINTA_RUJUKAN'] = &$this->MINTA_RUJUKAN;

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_NORUJUKAN_SEP', 'NORUJUKAN_SEP', '`NORUJUKAN_SEP`', '`NORUJUKAN_SEP`', 200, -1, FALSE, '`NORUJUKAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NORUJUKAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NORUJUKAN_SEP'] = &$this->NORUJUKAN_SEP;

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PPKRUJUKANASAL_SEP', 'PPKRUJUKANASAL_SEP', '`PPKRUJUKANASAL_SEP`', '`PPKRUJUKANASAL_SEP`', 200, -1, FALSE, '`PPKRUJUKANASAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PPKRUJUKANASAL_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PPKRUJUKANASAL_SEP'] = &$this->PPKRUJUKANASAL_SEP;

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_NAMAPPKRUJUKANASAL_SEP', 'NAMAPPKRUJUKANASAL_SEP', '`NAMAPPKRUJUKANASAL_SEP`', '`NAMAPPKRUJUKANASAL_SEP`', 200, -1, FALSE, '`NAMAPPKRUJUKANASAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMAPPKRUJUKANASAL_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NAMAPPKRUJUKANASAL_SEP'] = &$this->NAMAPPKRUJUKANASAL_SEP;

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PPKPELAYANAN_SEP', 'PPKPELAYANAN_SEP', '`PPKPELAYANAN_SEP`', '`PPKPELAYANAN_SEP`', 200, -1, FALSE, '`PPKPELAYANAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PPKPELAYANAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PPKPELAYANAN_SEP'] = &$this->PPKPELAYANAN_SEP;

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_JENISPERAWATAN_SEP', 'JENISPERAWATAN_SEP', '`JENISPERAWATAN_SEP`', '`JENISPERAWATAN_SEP`', 3, -1, FALSE, '`JENISPERAWATAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JENISPERAWATAN_SEP->Sortable = FALSE; // Allow sort
		$this->JENISPERAWATAN_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['JENISPERAWATAN_SEP'] = &$this->JENISPERAWATAN_SEP;

		// CATATAN_SEP
		$this->CATATAN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_CATATAN_SEP', 'CATATAN_SEP', '`CATATAN_SEP`', '`CATATAN_SEP`', 200, -1, FALSE, '`CATATAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CATATAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['CATATAN_SEP'] = &$this->CATATAN_SEP;

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_DIAGNOSAAWAL_SEP', 'DIAGNOSAAWAL_SEP', '`DIAGNOSAAWAL_SEP`', '`DIAGNOSAAWAL_SEP`', 200, -1, FALSE, '`DIAGNOSAAWAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DIAGNOSAAWAL_SEP->Sortable = FALSE; // Allow sort
		$this->fields['DIAGNOSAAWAL_SEP'] = &$this->DIAGNOSAAWAL_SEP;

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_NAMADIAGNOSA_SEP', 'NAMADIAGNOSA_SEP', '`NAMADIAGNOSA_SEP`', '`NAMADIAGNOSA_SEP`', 200, -1, FALSE, '`NAMADIAGNOSA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMADIAGNOSA_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NAMADIAGNOSA_SEP'] = &$this->NAMADIAGNOSA_SEP;

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_LAKALANTAS_SEP', 'LAKALANTAS_SEP', '`LAKALANTAS_SEP`', '`LAKALANTAS_SEP`', 3, -1, FALSE, '`LAKALANTAS_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LAKALANTAS_SEP->Sortable = FALSE; // Allow sort
		$this->LAKALANTAS_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['LAKALANTAS_SEP'] = &$this->LAKALANTAS_SEP;

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS = new cField('t_pendaftaran', 't_pendaftaran', 'x_LOKASILAKALANTAS', 'LOKASILAKALANTAS', '`LOKASILAKALANTAS`', '`LOKASILAKALANTAS`', 200, -1, FALSE, '`LOKASILAKALANTAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LOKASILAKALANTAS->Sortable = FALSE; // Allow sort
		$this->fields['LOKASILAKALANTAS'] = &$this->LOKASILAKALANTAS;

		// USER
		$this->USER = new cField('t_pendaftaran', 't_pendaftaran', 'x_USER', 'USER', '`USER`', '`USER`', 200, -1, FALSE, '`USER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER->Sortable = FALSE; // Allow sort
		$this->fields['USER'] = &$this->USER;

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan = new cField('t_pendaftaran', 't_pendaftaran', 'x_cek_data_kepesertaan', 'cek_data_kepesertaan', '`cek_data_kepesertaan`', '`cek_data_kepesertaan`', 3, -1, FALSE, '`cek_data_kepesertaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cek_data_kepesertaan->Sortable = FALSE; // Allow sort
		$this->cek_data_kepesertaan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cek_data_kepesertaan'] = &$this->cek_data_kepesertaan;

		// generate_sep
		$this->generate_sep = new cField('t_pendaftaran', 't_pendaftaran', 'x_generate_sep', 'generate_sep', '`generate_sep`', '`generate_sep`', 3, -1, FALSE, '`generate_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->generate_sep->Sortable = FALSE; // Allow sort
		$this->generate_sep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['generate_sep'] = &$this->generate_sep;

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTANIK_SEP', 'PESERTANIK_SEP', '`PESERTANIK_SEP`', '`PESERTANIK_SEP`', 200, -1, FALSE, '`PESERTANIK_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTANIK_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTANIK_SEP'] = &$this->PESERTANIK_SEP;

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTANAMA_SEP', 'PESERTANAMA_SEP', '`PESERTANAMA_SEP`', '`PESERTANAMA_SEP`', 200, -1, FALSE, '`PESERTANAMA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTANAMA_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTANAMA_SEP'] = &$this->PESERTANAMA_SEP;

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTAJENISKELAMIN_SEP', 'PESERTAJENISKELAMIN_SEP', '`PESERTAJENISKELAMIN_SEP`', '`PESERTAJENISKELAMIN_SEP`', 200, -1, FALSE, '`PESERTAJENISKELAMIN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTAJENISKELAMIN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTAJENISKELAMIN_SEP'] = &$this->PESERTAJENISKELAMIN_SEP;

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTANAMAKELAS_SEP', 'PESERTANAMAKELAS_SEP', '`PESERTANAMAKELAS_SEP`', '`PESERTANAMAKELAS_SEP`', 200, -1, FALSE, '`PESERTANAMAKELAS_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTANAMAKELAS_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTANAMAKELAS_SEP'] = &$this->PESERTANAMAKELAS_SEP;

		// PESERTAPISAT
		$this->PESERTAPISAT = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTAPISAT', 'PESERTAPISAT', '`PESERTAPISAT`', '`PESERTAPISAT`', 200, -1, FALSE, '`PESERTAPISAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTAPISAT->Sortable = FALSE; // Allow sort
		$this->fields['PESERTAPISAT'] = &$this->PESERTAPISAT;

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTATGLLAHIR', 'PESERTATGLLAHIR', '`PESERTATGLLAHIR`', '`PESERTATGLLAHIR`', 200, -1, FALSE, '`PESERTATGLLAHIR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTATGLLAHIR->Sortable = FALSE; // Allow sort
		$this->fields['PESERTATGLLAHIR'] = &$this->PESERTATGLLAHIR;

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTAJENISPESERTA_SEP', 'PESERTAJENISPESERTA_SEP', '`PESERTAJENISPESERTA_SEP`', '`PESERTAJENISPESERTA_SEP`', 200, -1, FALSE, '`PESERTAJENISPESERTA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTAJENISPESERTA_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTAJENISPESERTA_SEP'] = &$this->PESERTAJENISPESERTA_SEP;

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTANAMAJENISPESERTA_SEP', 'PESERTANAMAJENISPESERTA_SEP', '`PESERTANAMAJENISPESERTA_SEP`', '`PESERTANAMAJENISPESERTA_SEP`', 200, -1, FALSE, '`PESERTANAMAJENISPESERTA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTANAMAJENISPESERTA_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTANAMAJENISPESERTA_SEP'] = &$this->PESERTANAMAJENISPESERTA_SEP;

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_PESERTATGLCETAKKARTU_SEP', 'PESERTATGLCETAKKARTU_SEP', '`PESERTATGLCETAKKARTU_SEP`', ew_CastDateFieldForLike('`PESERTATGLCETAKKARTU_SEP`', 0, "DB"), 133, 0, FALSE, '`PESERTATGLCETAKKARTU_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTATGLCETAKKARTU_SEP->Sortable = FALSE; // Allow sort
		$this->PESERTATGLCETAKKARTU_SEP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['PESERTATGLCETAKKARTU_SEP'] = &$this->PESERTATGLCETAKKARTU_SEP;

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_POLITUJUAN_SEP', 'POLITUJUAN_SEP', '`POLITUJUAN_SEP`', '`POLITUJUAN_SEP`', 200, -1, FALSE, '`POLITUJUAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->POLITUJUAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['POLITUJUAN_SEP'] = &$this->POLITUJUAN_SEP;

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_NAMAPOLITUJUAN_SEP', 'NAMAPOLITUJUAN_SEP', '`NAMAPOLITUJUAN_SEP`', '`NAMAPOLITUJUAN_SEP`', 200, -1, FALSE, '`NAMAPOLITUJUAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMAPOLITUJUAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NAMAPOLITUJUAN_SEP'] = &$this->NAMAPOLITUJUAN_SEP;

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_KDPPKRUJUKAN_SEP', 'KDPPKRUJUKAN_SEP', '`KDPPKRUJUKAN_SEP`', '`KDPPKRUJUKAN_SEP`', 200, -1, FALSE, '`KDPPKRUJUKAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDPPKRUJUKAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['KDPPKRUJUKAN_SEP'] = &$this->KDPPKRUJUKAN_SEP;

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_NMPPKRUJUKAN_SEP', 'NMPPKRUJUKAN_SEP', '`NMPPKRUJUKAN_SEP`', '`NMPPKRUJUKAN_SEP`', 200, -1, FALSE, '`NMPPKRUJUKAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NMPPKRUJUKAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NMPPKRUJUKAN_SEP'] = &$this->NMPPKRUJUKAN_SEP;

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP = new cField('t_pendaftaran', 't_pendaftaran', 'x_UPDATETGLPLNG_SEP', 'UPDATETGLPLNG_SEP', '`UPDATETGLPLNG_SEP`', ew_CastDateFieldForLike('`UPDATETGLPLNG_SEP`', 0, "DB"), 135, 0, FALSE, '`UPDATETGLPLNG_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->UPDATETGLPLNG_SEP->Sortable = FALSE; // Allow sort
		$this->UPDATETGLPLNG_SEP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['UPDATETGLPLNG_SEP'] = &$this->UPDATETGLPLNG_SEP;

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng = new cField('t_pendaftaran', 't_pendaftaran', 'x_bridging_upt_tglplng', 'bridging_upt_tglplng', '`bridging_upt_tglplng`', '`bridging_upt_tglplng`', 200, -1, FALSE, '`bridging_upt_tglplng`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bridging_upt_tglplng->Sortable = FALSE; // Allow sort
		$this->fields['bridging_upt_tglplng'] = &$this->bridging_upt_tglplng;

		// mapingtransaksi
		$this->mapingtransaksi = new cField('t_pendaftaran', 't_pendaftaran', 'x_mapingtransaksi', 'mapingtransaksi', '`mapingtransaksi`', '`mapingtransaksi`', 3, -1, FALSE, '`mapingtransaksi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->mapingtransaksi->Sortable = FALSE; // Allow sort
		$this->mapingtransaksi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['mapingtransaksi'] = &$this->mapingtransaksi;

		// bridging_no_rujukan
		$this->bridging_no_rujukan = new cField('t_pendaftaran', 't_pendaftaran', 'x_bridging_no_rujukan', 'bridging_no_rujukan', '`bridging_no_rujukan`', '`bridging_no_rujukan`', 3, -1, FALSE, '`bridging_no_rujukan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bridging_no_rujukan->Sortable = FALSE; // Allow sort
		$this->bridging_no_rujukan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_no_rujukan'] = &$this->bridging_no_rujukan;

		// bridging_hapus_sep
		$this->bridging_hapus_sep = new cField('t_pendaftaran', 't_pendaftaran', 'x_bridging_hapus_sep', 'bridging_hapus_sep', '`bridging_hapus_sep`', '`bridging_hapus_sep`', 3, -1, FALSE, '`bridging_hapus_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bridging_hapus_sep->Sortable = FALSE; // Allow sort
		$this->bridging_hapus_sep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_hapus_sep'] = &$this->bridging_hapus_sep;

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka = new cField('t_pendaftaran', 't_pendaftaran', 'x_bridging_kepesertaan_by_no_ka', 'bridging_kepesertaan_by_no_ka', '`bridging_kepesertaan_by_no_ka`', '`bridging_kepesertaan_by_no_ka`', 3, -1, FALSE, '`bridging_kepesertaan_by_no_ka`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bridging_kepesertaan_by_no_ka->Sortable = FALSE; // Allow sort
		$this->bridging_kepesertaan_by_no_ka->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_kepesertaan_by_no_ka'] = &$this->bridging_kepesertaan_by_no_ka;

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS = new cField('t_pendaftaran', 't_pendaftaran', 'x_NOKARTU_BPJS', 'NOKARTU_BPJS', '`NOKARTU_BPJS`', '`NOKARTU_BPJS`', 200, -1, FALSE, '`NOKARTU_BPJS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOKARTU_BPJS->Sortable = FALSE; // Allow sort
		$this->fields['NOKARTU_BPJS'] = &$this->NOKARTU_BPJS;

		// counter_cetak_kartu
		$this->counter_cetak_kartu = new cField('t_pendaftaran', 't_pendaftaran', 'x_counter_cetak_kartu', 'counter_cetak_kartu', '`counter_cetak_kartu`', '`counter_cetak_kartu`', 3, -1, FALSE, '`counter_cetak_kartu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->counter_cetak_kartu->Sortable = FALSE; // Allow sort
		$this->counter_cetak_kartu->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['counter_cetak_kartu'] = &$this->counter_cetak_kartu;

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik = new cField('t_pendaftaran', 't_pendaftaran', 'x_bridging_kepesertaan_by_nik', 'bridging_kepesertaan_by_nik', '`bridging_kepesertaan_by_nik`', '`bridging_kepesertaan_by_nik`', 3, -1, FALSE, '`bridging_kepesertaan_by_nik`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bridging_kepesertaan_by_nik->Sortable = FALSE; // Allow sort
		$this->bridging_kepesertaan_by_nik->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_kepesertaan_by_nik'] = &$this->bridging_kepesertaan_by_nik;

		// NOKTP
		$this->NOKTP = new cField('t_pendaftaran', 't_pendaftaran', 'x_NOKTP', 'NOKTP', '`NOKTP`', '`NOKTP`', 200, -1, FALSE, '`NOKTP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOKTP->Sortable = FALSE; // Allow sort
		$this->fields['NOKTP'] = &$this->NOKTP;

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan = new cField('t_pendaftaran', 't_pendaftaran', 'x_bridging_by_no_rujukan', 'bridging_by_no_rujukan', '`bridging_by_no_rujukan`', '`bridging_by_no_rujukan`', 3, -1, FALSE, '`bridging_by_no_rujukan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bridging_by_no_rujukan->Sortable = FALSE; // Allow sort
		$this->bridging_by_no_rujukan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_by_no_rujukan'] = &$this->bridging_by_no_rujukan;

		// maping_hapus_sep
		$this->maping_hapus_sep = new cField('t_pendaftaran', 't_pendaftaran', 'x_maping_hapus_sep', 'maping_hapus_sep', '`maping_hapus_sep`', '`maping_hapus_sep`', 3, -1, FALSE, '`maping_hapus_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->maping_hapus_sep->Sortable = FALSE; // Allow sort
		$this->maping_hapus_sep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['maping_hapus_sep'] = &$this->maping_hapus_sep;

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap = new cField('t_pendaftaran', 't_pendaftaran', 'x_counter_cetak_kartu_ranap', 'counter_cetak_kartu_ranap', '`counter_cetak_kartu_ranap`', '`counter_cetak_kartu_ranap`', 3, -1, FALSE, '`counter_cetak_kartu_ranap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->counter_cetak_kartu_ranap->Sortable = FALSE; // Allow sort
		$this->counter_cetak_kartu_ranap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['counter_cetak_kartu_ranap'] = &$this->counter_cetak_kartu_ranap;

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_PENDAFTARAN', 'BIAYA_PENDAFTARAN', '`BIAYA_PENDAFTARAN`', '`BIAYA_PENDAFTARAN`', 5, -1, FALSE, '`BIAYA_PENDAFTARAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_PENDAFTARAN->Sortable = FALSE; // Allow sort
		$this->BIAYA_PENDAFTARAN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_PENDAFTARAN'] = &$this->BIAYA_PENDAFTARAN;

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_POLI', 'BIAYA_TINDAKAN_POLI', '`BIAYA_TINDAKAN_POLI`', '`BIAYA_TINDAKAN_POLI`', 5, -1, FALSE, '`BIAYA_TINDAKAN_POLI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_POLI->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_POLI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_POLI'] = &$this->BIAYA_TINDAKAN_POLI;

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_RADIOLOGI', 'BIAYA_TINDAKAN_RADIOLOGI', '`BIAYA_TINDAKAN_RADIOLOGI`', '`BIAYA_TINDAKAN_RADIOLOGI`', 5, -1, FALSE, '`BIAYA_TINDAKAN_RADIOLOGI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_RADIOLOGI->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_RADIOLOGI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_RADIOLOGI'] = &$this->BIAYA_TINDAKAN_RADIOLOGI;

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_LABORAT', 'BIAYA_TINDAKAN_LABORAT', '`BIAYA_TINDAKAN_LABORAT`', '`BIAYA_TINDAKAN_LABORAT`', 5, -1, FALSE, '`BIAYA_TINDAKAN_LABORAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_LABORAT->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_LABORAT->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_LABORAT'] = &$this->BIAYA_TINDAKAN_LABORAT;

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_KONSULTASI', 'BIAYA_TINDAKAN_KONSULTASI', '`BIAYA_TINDAKAN_KONSULTASI`', '`BIAYA_TINDAKAN_KONSULTASI`', 5, -1, FALSE, '`BIAYA_TINDAKAN_KONSULTASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_KONSULTASI->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_KONSULTASI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_KONSULTASI'] = &$this->BIAYA_TINDAKAN_KONSULTASI;

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TARIF_DOKTER', 'BIAYA_TARIF_DOKTER', '`BIAYA_TARIF_DOKTER`', '`BIAYA_TARIF_DOKTER`', 5, -1, FALSE, '`BIAYA_TARIF_DOKTER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TARIF_DOKTER->Sortable = FALSE; // Allow sort
		$this->BIAYA_TARIF_DOKTER->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TARIF_DOKTER'] = &$this->BIAYA_TARIF_DOKTER;

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TARIF_DOKTER_KONSUL', 'BIAYA_TARIF_DOKTER_KONSUL', '`BIAYA_TARIF_DOKTER_KONSUL`', '`BIAYA_TARIF_DOKTER_KONSUL`', 5, -1, FALSE, '`BIAYA_TARIF_DOKTER_KONSUL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TARIF_DOKTER_KONSUL->Sortable = FALSE; // Allow sort
		$this->BIAYA_TARIF_DOKTER_KONSUL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TARIF_DOKTER_KONSUL'] = &$this->BIAYA_TARIF_DOKTER_KONSUL;

		// INCLUDE
		$this->INCLUDE = new cField('t_pendaftaran', 't_pendaftaran', 'x_INCLUDE', 'INCLUDE', '`INCLUDE`', '`INCLUDE`', 3, -1, FALSE, '`INCLUDE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->INCLUDE->Sortable = FALSE; // Allow sort
		$this->INCLUDE->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['INCLUDE'] = &$this->INCLUDE;

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_kelas_rawat_rajal', 'eklaim_kelas_rawat_rajal', '`eklaim_kelas_rawat_rajal`', '`eklaim_kelas_rawat_rajal`', 3, -1, FALSE, '`eklaim_kelas_rawat_rajal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_kelas_rawat_rajal->Sortable = FALSE; // Allow sort
		$this->eklaim_kelas_rawat_rajal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_kelas_rawat_rajal'] = &$this->eklaim_kelas_rawat_rajal;

		// eklaim_adl_score
		$this->eklaim_adl_score = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_adl_score', 'eklaim_adl_score', '`eklaim_adl_score`', '`eklaim_adl_score`', 3, -1, FALSE, '`eklaim_adl_score`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_adl_score->Sortable = FALSE; // Allow sort
		$this->eklaim_adl_score->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_adl_score'] = &$this->eklaim_adl_score;

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_adl_sub_acute', 'eklaim_adl_sub_acute', '`eklaim_adl_sub_acute`', '`eklaim_adl_sub_acute`', 3, -1, FALSE, '`eklaim_adl_sub_acute`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_adl_sub_acute->Sortable = FALSE; // Allow sort
		$this->eklaim_adl_sub_acute->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_adl_sub_acute'] = &$this->eklaim_adl_sub_acute;

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_adl_chronic', 'eklaim_adl_chronic', '`eklaim_adl_chronic`', '`eklaim_adl_chronic`', 3, -1, FALSE, '`eklaim_adl_chronic`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_adl_chronic->Sortable = FALSE; // Allow sort
		$this->eklaim_adl_chronic->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_adl_chronic'] = &$this->eklaim_adl_chronic;

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_icu_indikator', 'eklaim_icu_indikator', '`eklaim_icu_indikator`', '`eklaim_icu_indikator`', 3, -1, FALSE, '`eklaim_icu_indikator`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_icu_indikator->Sortable = FALSE; // Allow sort
		$this->eklaim_icu_indikator->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_icu_indikator'] = &$this->eklaim_icu_indikator;

		// eklaim_icu_los
		$this->eklaim_icu_los = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_icu_los', 'eklaim_icu_los', '`eklaim_icu_los`', '`eklaim_icu_los`', 3, -1, FALSE, '`eklaim_icu_los`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_icu_los->Sortable = FALSE; // Allow sort
		$this->eklaim_icu_los->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_icu_los'] = &$this->eklaim_icu_los;

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_ventilator_hour', 'eklaim_ventilator_hour', '`eklaim_ventilator_hour`', '`eklaim_ventilator_hour`', 3, -1, FALSE, '`eklaim_ventilator_hour`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_ventilator_hour->Sortable = FALSE; // Allow sort
		$this->eklaim_ventilator_hour->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_ventilator_hour'] = &$this->eklaim_ventilator_hour;

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_upgrade_class_ind', 'eklaim_upgrade_class_ind', '`eklaim_upgrade_class_ind`', '`eklaim_upgrade_class_ind`', 3, -1, FALSE, '`eklaim_upgrade_class_ind`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_upgrade_class_ind->Sortable = FALSE; // Allow sort
		$this->eklaim_upgrade_class_ind->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_upgrade_class_ind'] = &$this->eklaim_upgrade_class_ind;

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_upgrade_class_class', 'eklaim_upgrade_class_class', '`eklaim_upgrade_class_class`', '`eklaim_upgrade_class_class`', 200, -1, FALSE, '`eklaim_upgrade_class_class`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_upgrade_class_class->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_upgrade_class_class'] = &$this->eklaim_upgrade_class_class;

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_upgrade_class_los', 'eklaim_upgrade_class_los', '`eklaim_upgrade_class_los`', '`eklaim_upgrade_class_los`', 3, -1, FALSE, '`eklaim_upgrade_class_los`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_upgrade_class_los->Sortable = FALSE; // Allow sort
		$this->eklaim_upgrade_class_los->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_upgrade_class_los'] = &$this->eklaim_upgrade_class_los;

		// eklaim_birth_weight
		$this->eklaim_birth_weight = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_birth_weight', 'eklaim_birth_weight', '`eklaim_birth_weight`', '`eklaim_birth_weight`', 3, -1, FALSE, '`eklaim_birth_weight`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_birth_weight->Sortable = FALSE; // Allow sort
		$this->eklaim_birth_weight->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_birth_weight'] = &$this->eklaim_birth_weight;

		// eklaim_discharge_status
		$this->eklaim_discharge_status = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_discharge_status', 'eklaim_discharge_status', '`eklaim_discharge_status`', '`eklaim_discharge_status`', 3, -1, FALSE, '`eklaim_discharge_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_discharge_status->Sortable = FALSE; // Allow sort
		$this->eklaim_discharge_status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_discharge_status'] = &$this->eklaim_discharge_status;

		// eklaim_diagnosa
		$this->eklaim_diagnosa = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_diagnosa', 'eklaim_diagnosa', '`eklaim_diagnosa`', '`eklaim_diagnosa`', 200, -1, FALSE, '`eklaim_diagnosa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_diagnosa->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_diagnosa'] = &$this->eklaim_diagnosa;

		// eklaim_procedure
		$this->eklaim_procedure = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_procedure', 'eklaim_procedure', '`eklaim_procedure`', '`eklaim_procedure`', 200, -1, FALSE, '`eklaim_procedure`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_procedure->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_procedure'] = &$this->eklaim_procedure;

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_tarif_rs', 'eklaim_tarif_rs', '`eklaim_tarif_rs`', '`eklaim_tarif_rs`', 5, -1, FALSE, '`eklaim_tarif_rs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_tarif_rs->Sortable = FALSE; // Allow sort
		$this->eklaim_tarif_rs->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['eklaim_tarif_rs'] = &$this->eklaim_tarif_rs;

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_tarif_poli_eks', 'eklaim_tarif_poli_eks', '`eklaim_tarif_poli_eks`', '`eklaim_tarif_poli_eks`', 5, -1, FALSE, '`eklaim_tarif_poli_eks`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_tarif_poli_eks->Sortable = FALSE; // Allow sort
		$this->eklaim_tarif_poli_eks->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['eklaim_tarif_poli_eks'] = &$this->eklaim_tarif_poli_eks;

		// eklaim_id_dokter
		$this->eklaim_id_dokter = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_id_dokter', 'eklaim_id_dokter', '`eklaim_id_dokter`', '`eklaim_id_dokter`', 3, -1, FALSE, '`eklaim_id_dokter`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_id_dokter->Sortable = FALSE; // Allow sort
		$this->eklaim_id_dokter->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_id_dokter'] = &$this->eklaim_id_dokter;

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_nama_dokter', 'eklaim_nama_dokter', '`eklaim_nama_dokter`', '`eklaim_nama_dokter`', 200, -1, FALSE, '`eklaim_nama_dokter`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_nama_dokter->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_nama_dokter'] = &$this->eklaim_nama_dokter;

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_kode_tarif', 'eklaim_kode_tarif', '`eklaim_kode_tarif`', '`eklaim_kode_tarif`', 200, -1, FALSE, '`eklaim_kode_tarif`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_kode_tarif->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_kode_tarif'] = &$this->eklaim_kode_tarif;

		// eklaim_payor_id
		$this->eklaim_payor_id = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_payor_id', 'eklaim_payor_id', '`eklaim_payor_id`', '`eklaim_payor_id`', 3, -1, FALSE, '`eklaim_payor_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_payor_id->Sortable = FALSE; // Allow sort
		$this->eklaim_payor_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_payor_id'] = &$this->eklaim_payor_id;

		// eklaim_payor_cd
		$this->eklaim_payor_cd = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_payor_cd', 'eklaim_payor_cd', '`eklaim_payor_cd`', '`eklaim_payor_cd`', 200, -1, FALSE, '`eklaim_payor_cd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_payor_cd->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_payor_cd'] = &$this->eklaim_payor_cd;

		// eklaim_coder_nik
		$this->eklaim_coder_nik = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_coder_nik', 'eklaim_coder_nik', '`eklaim_coder_nik`', '`eklaim_coder_nik`', 200, -1, FALSE, '`eklaim_coder_nik`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_coder_nik->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_coder_nik'] = &$this->eklaim_coder_nik;

		// eklaim_los
		$this->eklaim_los = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_los', 'eklaim_los', '`eklaim_los`', '`eklaim_los`', 3, -1, FALSE, '`eklaim_los`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_los->Sortable = FALSE; // Allow sort
		$this->eklaim_los->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_los'] = &$this->eklaim_los;

		// eklaim_patient_id
		$this->eklaim_patient_id = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_patient_id', 'eklaim_patient_id', '`eklaim_patient_id`', '`eklaim_patient_id`', 200, -1, FALSE, '`eklaim_patient_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_patient_id->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_patient_id'] = &$this->eklaim_patient_id;

		// eklaim_admission_id
		$this->eklaim_admission_id = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_admission_id', 'eklaim_admission_id', '`eklaim_admission_id`', '`eklaim_admission_id`', 200, -1, FALSE, '`eklaim_admission_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_admission_id->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_admission_id'] = &$this->eklaim_admission_id;

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_hospital_admission_id', 'eklaim_hospital_admission_id', '`eklaim_hospital_admission_id`', '`eklaim_hospital_admission_id`', 200, -1, FALSE, '`eklaim_hospital_admission_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_hospital_admission_id->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_hospital_admission_id'] = &$this->eklaim_hospital_admission_id;

		// bridging_hapussep
		$this->bridging_hapussep = new cField('t_pendaftaran', 't_pendaftaran', 'x_bridging_hapussep', 'bridging_hapussep', '`bridging_hapussep`', '`bridging_hapussep`', 3, -1, FALSE, '`bridging_hapussep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bridging_hapussep->Sortable = FALSE; // Allow sort
		$this->bridging_hapussep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_hapussep'] = &$this->bridging_hapussep;

		// user_penghapus_sep
		$this->user_penghapus_sep = new cField('t_pendaftaran', 't_pendaftaran', 'x_user_penghapus_sep', 'user_penghapus_sep', '`user_penghapus_sep`', '`user_penghapus_sep`', 200, -1, FALSE, '`user_penghapus_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_penghapus_sep->Sortable = FALSE; // Allow sort
		$this->fields['user_penghapus_sep'] = &$this->user_penghapus_sep;

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_BILLING_RAJAL', 'BIAYA_BILLING_RAJAL', '`BIAYA_BILLING_RAJAL`', '`BIAYA_BILLING_RAJAL`', 5, -1, FALSE, '`BIAYA_BILLING_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_BILLING_RAJAL->Sortable = FALSE; // Allow sort
		$this->BIAYA_BILLING_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_BILLING_RAJAL'] = &$this->BIAYA_BILLING_RAJAL;

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_STATUS_PEMBAYARAN', 'STATUS_PEMBAYARAN', '`STATUS_PEMBAYARAN`', '`STATUS_PEMBAYARAN`', 3, -1, FALSE, '`STATUS_PEMBAYARAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->STATUS_PEMBAYARAN->Sortable = FALSE; // Allow sort
		$this->STATUS_PEMBAYARAN->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['STATUS_PEMBAYARAN'] = &$this->STATUS_PEMBAYARAN;

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_FISIOTERAPI', 'BIAYA_TINDAKAN_FISIOTERAPI', '`BIAYA_TINDAKAN_FISIOTERAPI`', '`BIAYA_TINDAKAN_FISIOTERAPI`', 5, -1, FALSE, '`BIAYA_TINDAKAN_FISIOTERAPI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_FISIOTERAPI->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_FISIOTERAPI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_FISIOTERAPI'] = &$this->BIAYA_TINDAKAN_FISIOTERAPI;

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_reg_pasien', 'eklaim_reg_pasien', '`eklaim_reg_pasien`', '`eklaim_reg_pasien`', 3, -1, FALSE, '`eklaim_reg_pasien`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_reg_pasien->Sortable = FALSE; // Allow sort
		$this->eklaim_reg_pasien->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_reg_pasien'] = &$this->eklaim_reg_pasien;

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_reg_klaim_baru', 'eklaim_reg_klaim_baru', '`eklaim_reg_klaim_baru`', '`eklaim_reg_klaim_baru`', 3, -1, FALSE, '`eklaim_reg_klaim_baru`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_reg_klaim_baru->Sortable = FALSE; // Allow sort
		$this->eklaim_reg_klaim_baru->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_reg_klaim_baru'] = &$this->eklaim_reg_klaim_baru;

		// eklaim_gruper1
		$this->eklaim_gruper1 = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_gruper1', 'eklaim_gruper1', '`eklaim_gruper1`', '`eklaim_gruper1`', 3, -1, FALSE, '`eklaim_gruper1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_gruper1->Sortable = FALSE; // Allow sort
		$this->eklaim_gruper1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_gruper1'] = &$this->eklaim_gruper1;

		// eklaim_gruper2
		$this->eklaim_gruper2 = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_gruper2', 'eklaim_gruper2', '`eklaim_gruper2`', '`eklaim_gruper2`', 3, -1, FALSE, '`eklaim_gruper2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_gruper2->Sortable = FALSE; // Allow sort
		$this->eklaim_gruper2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_gruper2'] = &$this->eklaim_gruper2;

		// eklaim_finalklaim
		$this->eklaim_finalklaim = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_finalklaim', 'eklaim_finalklaim', '`eklaim_finalklaim`', '`eklaim_finalklaim`', 3, -1, FALSE, '`eklaim_finalklaim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_finalklaim->Sortable = FALSE; // Allow sort
		$this->eklaim_finalklaim->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_finalklaim'] = &$this->eklaim_finalklaim;

		// eklaim_sendklaim
		$this->eklaim_sendklaim = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_sendklaim', 'eklaim_sendklaim', '`eklaim_sendklaim`', '`eklaim_sendklaim`', 3, -1, FALSE, '`eklaim_sendklaim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_sendklaim->Sortable = FALSE; // Allow sort
		$this->eklaim_sendklaim->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_sendklaim'] = &$this->eklaim_sendklaim;

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_flag_hapus_pasien', 'eklaim_flag_hapus_pasien', '`eklaim_flag_hapus_pasien`', '`eklaim_flag_hapus_pasien`', 3, -1, FALSE, '`eklaim_flag_hapus_pasien`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_flag_hapus_pasien->Sortable = FALSE; // Allow sort
		$this->eklaim_flag_hapus_pasien->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_flag_hapus_pasien'] = &$this->eklaim_flag_hapus_pasien;

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_flag_hapus_klaim', 'eklaim_flag_hapus_klaim', '`eklaim_flag_hapus_klaim`', '`eklaim_flag_hapus_klaim`', 3, -1, FALSE, '`eklaim_flag_hapus_klaim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_flag_hapus_klaim->Sortable = FALSE; // Allow sort
		$this->eklaim_flag_hapus_klaim->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_flag_hapus_klaim'] = &$this->eklaim_flag_hapus_klaim;

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_kemkes_dc_Status', 'eklaim_kemkes_dc_Status', '`eklaim_kemkes_dc_Status`', '`eklaim_kemkes_dc_Status`', 200, -1, FALSE, '`eklaim_kemkes_dc_Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_kemkes_dc_Status->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_kemkes_dc_Status'] = &$this->eklaim_kemkes_dc_Status;

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_bpjs_dc_Status', 'eklaim_bpjs_dc_Status', '`eklaim_bpjs_dc_Status`', '`eklaim_bpjs_dc_Status`', 200, -1, FALSE, '`eklaim_bpjs_dc_Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_bpjs_dc_Status->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_bpjs_dc_Status'] = &$this->eklaim_bpjs_dc_Status;

		// eklaim_cbg_code
		$this->eklaim_cbg_code = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_cbg_code', 'eklaim_cbg_code', '`eklaim_cbg_code`', '`eklaim_cbg_code`', 200, -1, FALSE, '`eklaim_cbg_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_cbg_code->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_cbg_code'] = &$this->eklaim_cbg_code;

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_cbg_descprition', 'eklaim_cbg_descprition', '`eklaim_cbg_descprition`', '`eklaim_cbg_descprition`', 200, -1, FALSE, '`eklaim_cbg_descprition`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_cbg_descprition->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_cbg_descprition'] = &$this->eklaim_cbg_descprition;

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_cbg_tariff', 'eklaim_cbg_tariff', '`eklaim_cbg_tariff`', '`eklaim_cbg_tariff`', 5, -1, FALSE, '`eklaim_cbg_tariff`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_cbg_tariff->Sortable = FALSE; // Allow sort
		$this->eklaim_cbg_tariff->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['eklaim_cbg_tariff'] = &$this->eklaim_cbg_tariff;

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_sub_acute_code', 'eklaim_sub_acute_code', '`eklaim_sub_acute_code`', '`eklaim_sub_acute_code`', 200, -1, FALSE, '`eklaim_sub_acute_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_sub_acute_code->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_sub_acute_code'] = &$this->eklaim_sub_acute_code;

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_sub_acute_deskripsi', 'eklaim_sub_acute_deskripsi', '`eklaim_sub_acute_deskripsi`', '`eklaim_sub_acute_deskripsi`', 200, -1, FALSE, '`eklaim_sub_acute_deskripsi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_sub_acute_deskripsi->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_sub_acute_deskripsi'] = &$this->eklaim_sub_acute_deskripsi;

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_sub_acute_tariff', 'eklaim_sub_acute_tariff', '`eklaim_sub_acute_tariff`', '`eklaim_sub_acute_tariff`', 5, -1, FALSE, '`eklaim_sub_acute_tariff`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_sub_acute_tariff->Sortable = FALSE; // Allow sort
		$this->eklaim_sub_acute_tariff->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['eklaim_sub_acute_tariff'] = &$this->eklaim_sub_acute_tariff;

		// eklaim_chronic_code
		$this->eklaim_chronic_code = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_chronic_code', 'eklaim_chronic_code', '`eklaim_chronic_code`', '`eklaim_chronic_code`', 200, -1, FALSE, '`eklaim_chronic_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_chronic_code->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_chronic_code'] = &$this->eklaim_chronic_code;

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_chronic_deskripsi', 'eklaim_chronic_deskripsi', '`eklaim_chronic_deskripsi`', '`eklaim_chronic_deskripsi`', 200, -1, FALSE, '`eklaim_chronic_deskripsi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_chronic_deskripsi->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_chronic_deskripsi'] = &$this->eklaim_chronic_deskripsi;

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_chronic_tariff', 'eklaim_chronic_tariff', '`eklaim_chronic_tariff`', '`eklaim_chronic_tariff`', 5, -1, FALSE, '`eklaim_chronic_tariff`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_chronic_tariff->Sortable = FALSE; // Allow sort
		$this->eklaim_chronic_tariff->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['eklaim_chronic_tariff'] = &$this->eklaim_chronic_tariff;

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_inacbg_version', 'eklaim_inacbg_version', '`eklaim_inacbg_version`', '`eklaim_inacbg_version`', 200, -1, FALSE, '`eklaim_inacbg_version`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_inacbg_version->Sortable = FALSE; // Allow sort
		$this->fields['eklaim_inacbg_version'] = &$this->eklaim_inacbg_version;

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_IBS_RAJAL', 'BIAYA_TINDAKAN_IBS_RAJAL', '`BIAYA_TINDAKAN_IBS_RAJAL`', '`BIAYA_TINDAKAN_IBS_RAJAL`', 5, -1, FALSE, '`BIAYA_TINDAKAN_IBS_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_IBS_RAJAL->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_IBS_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_IBS_RAJAL'] = &$this->BIAYA_TINDAKAN_IBS_RAJAL;

		// VERIFY_ICD
		$this->VERIFY_ICD = new cField('t_pendaftaran', 't_pendaftaran', 'x_VERIFY_ICD', 'VERIFY_ICD', '`VERIFY_ICD`', '`VERIFY_ICD`', 3, -1, FALSE, '`VERIFY_ICD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->VERIFY_ICD->Sortable = FALSE; // Allow sort
		$this->VERIFY_ICD->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['VERIFY_ICD'] = &$this->VERIFY_ICD;

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2 = new cField('t_pendaftaran', 't_pendaftaran', 'x_bridging_rujukan_faskes_2', 'bridging_rujukan_faskes_2', '`bridging_rujukan_faskes_2`', '`bridging_rujukan_faskes_2`', 3, -1, FALSE, '`bridging_rujukan_faskes_2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bridging_rujukan_faskes_2->Sortable = FALSE; // Allow sort
		$this->bridging_rujukan_faskes_2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_rujukan_faskes_2'] = &$this->bridging_rujukan_faskes_2;

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_reedit_claim', 'eklaim_reedit_claim', '`eklaim_reedit_claim`', '`eklaim_reedit_claim`', 3, -1, FALSE, '`eklaim_reedit_claim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_reedit_claim->Sortable = FALSE; // Allow sort
		$this->eklaim_reedit_claim->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eklaim_reedit_claim'] = &$this->eklaim_reedit_claim;

		// KETERANGAN
		$this->KETERANGAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_KETERANGAN', 'KETERANGAN', '`KETERANGAN`', '`KETERANGAN`', 200, -1, FALSE, '`KETERANGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETERANGAN->Sortable = FALSE; // Allow sort
		$this->fields['KETERANGAN'] = &$this->KETERANGAN;

		// TGLLAHIR
		$this->TGLLAHIR = new cField('t_pendaftaran', 't_pendaftaran', 'x_TGLLAHIR', 'TGLLAHIR', '`TGLLAHIR`', ew_CastDateFieldForLike('`TGLLAHIR`', 0, "DB"), 133, 0, FALSE, '`TGLLAHIR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TGLLAHIR->Sortable = FALSE; // Allow sort
		$this->TGLLAHIR->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TGLLAHIR'] = &$this->TGLLAHIR;

		// USER_KASIR
		$this->USER_KASIR = new cField('t_pendaftaran', 't_pendaftaran', 'x_USER_KASIR', 'USER_KASIR', '`USER_KASIR`', '`USER_KASIR`', 200, -1, FALSE, '`USER_KASIR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER_KASIR->Sortable = FALSE; // Allow sort
		$this->fields['USER_KASIR'] = &$this->USER_KASIR;

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_tgl_gruping', 'eklaim_tgl_gruping', '`eklaim_tgl_gruping`', ew_CastDateFieldForLike('`eklaim_tgl_gruping`', 0, "DB"), 135, 0, FALSE, '`eklaim_tgl_gruping`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_tgl_gruping->Sortable = FALSE; // Allow sort
		$this->eklaim_tgl_gruping->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['eklaim_tgl_gruping'] = &$this->eklaim_tgl_gruping;

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_tgl_finalklaim', 'eklaim_tgl_finalklaim', '`eklaim_tgl_finalklaim`', ew_CastDateFieldForLike('`eklaim_tgl_finalklaim`', 0, "DB"), 135, 0, FALSE, '`eklaim_tgl_finalklaim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_tgl_finalklaim->Sortable = FALSE; // Allow sort
		$this->eklaim_tgl_finalklaim->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['eklaim_tgl_finalklaim'] = &$this->eklaim_tgl_finalklaim;

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim = new cField('t_pendaftaran', 't_pendaftaran', 'x_eklaim_tgl_kirim_klaim', 'eklaim_tgl_kirim_klaim', '`eklaim_tgl_kirim_klaim`', ew_CastDateFieldForLike('`eklaim_tgl_kirim_klaim`', 0, "DB"), 135, 0, FALSE, '`eklaim_tgl_kirim_klaim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eklaim_tgl_kirim_klaim->Sortable = FALSE; // Allow sort
		$this->eklaim_tgl_kirim_klaim->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['eklaim_tgl_kirim_klaim'] = &$this->eklaim_tgl_kirim_klaim;

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_OBAT_RS', 'BIAYA_OBAT_RS', '`BIAYA_OBAT_RS`', '`BIAYA_OBAT_RS`', 5, -1, FALSE, '`BIAYA_OBAT_RS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_OBAT_RS->Sortable = FALSE; // Allow sort
		$this->BIAYA_OBAT_RS->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_OBAT_RS'] = &$this->BIAYA_OBAT_RS;

		// EKG_RAJAL
		$this->EKG_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_EKG_RAJAL', 'EKG_RAJAL', '`EKG_RAJAL`', '`EKG_RAJAL`', 5, -1, FALSE, '`EKG_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->EKG_RAJAL->Sortable = FALSE; // Allow sort
		$this->EKG_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['EKG_RAJAL'] = &$this->EKG_RAJAL;

		// USG_RAJAL
		$this->USG_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_USG_RAJAL', 'USG_RAJAL', '`USG_RAJAL`', '`USG_RAJAL`', 5, -1, FALSE, '`USG_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USG_RAJAL->Sortable = FALSE; // Allow sort
		$this->USG_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['USG_RAJAL'] = &$this->USG_RAJAL;

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_FISIOTERAPI_RAJAL', 'FISIOTERAPI_RAJAL', '`FISIOTERAPI_RAJAL`', '`FISIOTERAPI_RAJAL`', 5, -1, FALSE, '`FISIOTERAPI_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FISIOTERAPI_RAJAL->Sortable = FALSE; // Allow sort
		$this->FISIOTERAPI_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['FISIOTERAPI_RAJAL'] = &$this->FISIOTERAPI_RAJAL;

		// BHP_RAJAL
		$this->BHP_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_BHP_RAJAL', 'BHP_RAJAL', '`BHP_RAJAL`', '`BHP_RAJAL`', 5, -1, FALSE, '`BHP_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BHP_RAJAL->Sortable = FALSE; // Allow sort
		$this->BHP_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BHP_RAJAL'] = &$this->BHP_RAJAL;

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_ASKEP_IBS_RAJAL', 'BIAYA_TINDAKAN_ASKEP_IBS_RAJAL', '`BIAYA_TINDAKAN_ASKEP_IBS_RAJAL`', '`BIAYA_TINDAKAN_ASKEP_IBS_RAJAL`', 5, -1, FALSE, '`BIAYA_TINDAKAN_ASKEP_IBS_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_ASKEP_IBS_RAJAL'] = &$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL;

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_TMNO_IBS_RAJAL', 'BIAYA_TINDAKAN_TMNO_IBS_RAJAL', '`BIAYA_TINDAKAN_TMNO_IBS_RAJAL`', '`BIAYA_TINDAKAN_TMNO_IBS_RAJAL`', 5, -1, FALSE, '`BIAYA_TINDAKAN_TMNO_IBS_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_TMNO_IBS_RAJAL'] = &$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL;

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_TOTAL_BIAYA_IBS_RAJAL', 'TOTAL_BIAYA_IBS_RAJAL', '`TOTAL_BIAYA_IBS_RAJAL`', '`TOTAL_BIAYA_IBS_RAJAL`', 5, -1, FALSE, '`TOTAL_BIAYA_IBS_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_BIAYA_IBS_RAJAL->Sortable = FALSE; // Allow sort
		$this->TOTAL_BIAYA_IBS_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOTAL_BIAYA_IBS_RAJAL'] = &$this->TOTAL_BIAYA_IBS_RAJAL;

		// ORDER_LAB
		$this->ORDER_LAB = new cField('t_pendaftaran', 't_pendaftaran', 'x_ORDER_LAB', 'ORDER_LAB', '`ORDER_LAB`', '`ORDER_LAB`', 3, -1, FALSE, '`ORDER_LAB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ORDER_LAB->Sortable = FALSE; // Allow sort
		$this->ORDER_LAB->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ORDER_LAB'] = &$this->ORDER_LAB;

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI = new cField('t_pendaftaran', 't_pendaftaran', 'x_BILL_RAJAL_SELESAI', 'BILL_RAJAL_SELESAI', '`BILL_RAJAL_SELESAI`', '`BILL_RAJAL_SELESAI`', 3, -1, FALSE, '`BILL_RAJAL_SELESAI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BILL_RAJAL_SELESAI->Sortable = FALSE; // Allow sort
		$this->BILL_RAJAL_SELESAI->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['BILL_RAJAL_SELESAI'] = &$this->BILL_RAJAL_SELESAI;

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR = new cField('t_pendaftaran', 't_pendaftaran', 'x_INCLUDE_IDXDAFTAR', 'INCLUDE_IDXDAFTAR', '`INCLUDE_IDXDAFTAR`', '`INCLUDE_IDXDAFTAR`', 3, -1, FALSE, '`INCLUDE_IDXDAFTAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->INCLUDE_IDXDAFTAR->Sortable = FALSE; // Allow sort
		$this->INCLUDE_IDXDAFTAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['INCLUDE_IDXDAFTAR'] = &$this->INCLUDE_IDXDAFTAR;

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA = new cField('t_pendaftaran', 't_pendaftaran', 'x_INCLUDE_HARGA', 'INCLUDE_HARGA', '`INCLUDE_HARGA`', '`INCLUDE_HARGA`', 5, -1, FALSE, '`INCLUDE_HARGA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->INCLUDE_HARGA->Sortable = FALSE; // Allow sort
		$this->INCLUDE_HARGA->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['INCLUDE_HARGA'] = &$this->INCLUDE_HARGA;

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_JASA_SARANA', 'TARIF_JASA_SARANA', '`TARIF_JASA_SARANA`', '`TARIF_JASA_SARANA`', 5, -1, FALSE, '`TARIF_JASA_SARANA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_JASA_SARANA->Sortable = FALSE; // Allow sort
		$this->TARIF_JASA_SARANA->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_JASA_SARANA'] = &$this->TARIF_JASA_SARANA;

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_PENUNJANG_NON_MEDIS', 'TARIF_PENUNJANG_NON_MEDIS', '`TARIF_PENUNJANG_NON_MEDIS`', '`TARIF_PENUNJANG_NON_MEDIS`', 5, -1, FALSE, '`TARIF_PENUNJANG_NON_MEDIS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_PENUNJANG_NON_MEDIS->Sortable = FALSE; // Allow sort
		$this->TARIF_PENUNJANG_NON_MEDIS->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_PENUNJANG_NON_MEDIS'] = &$this->TARIF_PENUNJANG_NON_MEDIS;

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_ASUHAN_KEPERAWATAN', 'TARIF_ASUHAN_KEPERAWATAN', '`TARIF_ASUHAN_KEPERAWATAN`', '`TARIF_ASUHAN_KEPERAWATAN`', 5, -1, FALSE, '`TARIF_ASUHAN_KEPERAWATAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_ASUHAN_KEPERAWATAN->Sortable = FALSE; // Allow sort
		$this->TARIF_ASUHAN_KEPERAWATAN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_ASUHAN_KEPERAWATAN'] = &$this->TARIF_ASUHAN_KEPERAWATAN;

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_KDDOKTER_RAJAL', 'KDDOKTER_RAJAL', '`KDDOKTER_RAJAL`', '`KDDOKTER_RAJAL`', 3, -1, FALSE, '`KDDOKTER_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDDOKTER_RAJAL->Sortable = FALSE; // Allow sort
		$this->KDDOKTER_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDDOKTER_RAJAL'] = &$this->KDDOKTER_RAJAL;

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL = new cField('t_pendaftaran', 't_pendaftaran', 'x_KDDOKTER_KONSUL_RAJAL', 'KDDOKTER_KONSUL_RAJAL', '`KDDOKTER_KONSUL_RAJAL`', '`KDDOKTER_KONSUL_RAJAL`', 3, -1, FALSE, '`KDDOKTER_KONSUL_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDDOKTER_KONSUL_RAJAL->Sortable = FALSE; // Allow sort
		$this->KDDOKTER_KONSUL_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDDOKTER_KONSUL_RAJAL'] = &$this->KDDOKTER_KONSUL_RAJAL;

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_BILLING_RS', 'BIAYA_BILLING_RS', '`BIAYA_BILLING_RS`', '`BIAYA_BILLING_RS`', 5, -1, FALSE, '`BIAYA_BILLING_RS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_BILLING_RS->Sortable = FALSE; // Allow sort
		$this->BIAYA_BILLING_RS->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_BILLING_RS'] = &$this->BIAYA_BILLING_RS;

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_POLI_TMO', 'BIAYA_TINDAKAN_POLI_TMO', '`BIAYA_TINDAKAN_POLI_TMO`', '`BIAYA_TINDAKAN_POLI_TMO`', 5, -1, FALSE, '`BIAYA_TINDAKAN_POLI_TMO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_POLI_TMO->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_POLI_TMO->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_POLI_TMO'] = &$this->BIAYA_TINDAKAN_POLI_TMO;

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_POLI_KEPERAWATAN', 'BIAYA_TINDAKAN_POLI_KEPERAWATAN', '`BIAYA_TINDAKAN_POLI_KEPERAWATAN`', '`BIAYA_TINDAKAN_POLI_KEPERAWATAN`', 5, -1, FALSE, '`BIAYA_TINDAKAN_POLI_KEPERAWATAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_POLI_KEPERAWATAN'] = &$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN;

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO = new cField('t_pendaftaran', 't_pendaftaran', 'x_BHP_RAJAL_TMO', 'BHP_RAJAL_TMO', '`BHP_RAJAL_TMO`', '`BHP_RAJAL_TMO`', 5, -1, FALSE, '`BHP_RAJAL_TMO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BHP_RAJAL_TMO->Sortable = FALSE; // Allow sort
		$this->BHP_RAJAL_TMO->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BHP_RAJAL_TMO'] = &$this->BHP_RAJAL_TMO;

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_BHP_RAJAL_KEPERAWATAN', 'BHP_RAJAL_KEPERAWATAN', '`BHP_RAJAL_KEPERAWATAN`', '`BHP_RAJAL_KEPERAWATAN`', 5, -1, FALSE, '`BHP_RAJAL_KEPERAWATAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BHP_RAJAL_KEPERAWATAN->Sortable = FALSE; // Allow sort
		$this->BHP_RAJAL_KEPERAWATAN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BHP_RAJAL_KEPERAWATAN'] = &$this->BHP_RAJAL_KEPERAWATAN;

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_AKOMODASI', 'TARIF_AKOMODASI', '`TARIF_AKOMODASI`', '`TARIF_AKOMODASI`', 5, -1, FALSE, '`TARIF_AKOMODASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_AKOMODASI->Sortable = FALSE; // Allow sort
		$this->TARIF_AKOMODASI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_AKOMODASI'] = &$this->TARIF_AKOMODASI;

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_AMBULAN', 'TARIF_AMBULAN', '`TARIF_AMBULAN`', '`TARIF_AMBULAN`', 5, -1, FALSE, '`TARIF_AMBULAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_AMBULAN->Sortable = FALSE; // Allow sort
		$this->TARIF_AMBULAN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_AMBULAN'] = &$this->TARIF_AMBULAN;

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_OKSIGEN', 'TARIF_OKSIGEN', '`TARIF_OKSIGEN`', '`TARIF_OKSIGEN`', 5, -1, FALSE, '`TARIF_OKSIGEN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_OKSIGEN->Sortable = FALSE; // Allow sort
		$this->TARIF_OKSIGEN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_OKSIGEN'] = &$this->TARIF_OKSIGEN;

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_JENAZAH', 'BIAYA_TINDAKAN_JENAZAH', '`BIAYA_TINDAKAN_JENAZAH`', '`BIAYA_TINDAKAN_JENAZAH`', 5, -1, FALSE, '`BIAYA_TINDAKAN_JENAZAH`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_JENAZAH->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_JENAZAH->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_JENAZAH'] = &$this->BIAYA_TINDAKAN_JENAZAH;

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_BILLING_IGD', 'BIAYA_BILLING_IGD', '`BIAYA_BILLING_IGD`', '`BIAYA_BILLING_IGD`', 5, -1, FALSE, '`BIAYA_BILLING_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_BILLING_IGD->Sortable = FALSE; // Allow sort
		$this->BIAYA_BILLING_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_BILLING_IGD'] = &$this->BIAYA_BILLING_IGD;

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TINDAKAN_POLI_PERSALINAN', 'BIAYA_TINDAKAN_POLI_PERSALINAN', '`BIAYA_TINDAKAN_POLI_PERSALINAN`', '`BIAYA_TINDAKAN_POLI_PERSALINAN`', 5, -1, FALSE, '`BIAYA_TINDAKAN_POLI_PERSALINAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->Sortable = FALSE; // Allow sort
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TINDAKAN_POLI_PERSALINAN'] = &$this->BIAYA_TINDAKAN_POLI_PERSALINAN;

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_BHP_RAJAL_PERSALINAN', 'BHP_RAJAL_PERSALINAN', '`BHP_RAJAL_PERSALINAN`', '`BHP_RAJAL_PERSALINAN`', 5, -1, FALSE, '`BHP_RAJAL_PERSALINAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BHP_RAJAL_PERSALINAN->Sortable = FALSE; // Allow sort
		$this->BHP_RAJAL_PERSALINAN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BHP_RAJAL_PERSALINAN'] = &$this->BHP_RAJAL_PERSALINAN;

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_BIMBINGAN_ROHANI', 'TARIF_BIMBINGAN_ROHANI', '`TARIF_BIMBINGAN_ROHANI`', '`TARIF_BIMBINGAN_ROHANI`', 5, -1, FALSE, '`TARIF_BIMBINGAN_ROHANI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_BIMBINGAN_ROHANI->Sortable = FALSE; // Allow sort
		$this->TARIF_BIMBINGAN_ROHANI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_BIMBINGAN_ROHANI'] = &$this->TARIF_BIMBINGAN_ROHANI;

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2 = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_BILLING_RS2', 'BIAYA_BILLING_RS2', '`BIAYA_BILLING_RS2`', '`BIAYA_BILLING_RS2`', 5, -1, FALSE, '`BIAYA_BILLING_RS2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_BILLING_RS2->Sortable = FALSE; // Allow sort
		$this->BIAYA_BILLING_RS2->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_BILLING_RS2'] = &$this->BIAYA_BILLING_RS2;

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TARIF_DOKTER_IGD', 'BIAYA_TARIF_DOKTER_IGD', '`BIAYA_TARIF_DOKTER_IGD`', '`BIAYA_TARIF_DOKTER_IGD`', 5, -1, FALSE, '`BIAYA_TARIF_DOKTER_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TARIF_DOKTER_IGD->Sortable = FALSE; // Allow sort
		$this->BIAYA_TARIF_DOKTER_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TARIF_DOKTER_IGD'] = &$this->BIAYA_TARIF_DOKTER_IGD;

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_PENDAFTARAN_IGD', 'BIAYA_PENDAFTARAN_IGD', '`BIAYA_PENDAFTARAN_IGD`', '`BIAYA_PENDAFTARAN_IGD`', 5, -1, FALSE, '`BIAYA_PENDAFTARAN_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_PENDAFTARAN_IGD->Sortable = FALSE; // Allow sort
		$this->BIAYA_PENDAFTARAN_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_PENDAFTARAN_IGD'] = &$this->BIAYA_PENDAFTARAN_IGD;

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_BILLING_IBS', 'BIAYA_BILLING_IBS', '`BIAYA_BILLING_IBS`', '`BIAYA_BILLING_IBS`', 5, -1, FALSE, '`BIAYA_BILLING_IBS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_BILLING_IBS->Sortable = FALSE; // Allow sort
		$this->BIAYA_BILLING_IBS->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_BILLING_IBS'] = &$this->BIAYA_BILLING_IBS;

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_JASA_SARANA_IGD', 'TARIF_JASA_SARANA_IGD', '`TARIF_JASA_SARANA_IGD`', '`TARIF_JASA_SARANA_IGD`', 5, -1, FALSE, '`TARIF_JASA_SARANA_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_JASA_SARANA_IGD->Sortable = FALSE; // Allow sort
		$this->TARIF_JASA_SARANA_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_JASA_SARANA_IGD'] = &$this->TARIF_JASA_SARANA_IGD;

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TARIF_DOKTER_SPESIALIS_IGD', 'BIAYA_TARIF_DOKTER_SPESIALIS_IGD', '`BIAYA_TARIF_DOKTER_SPESIALIS_IGD`', '`BIAYA_TARIF_DOKTER_SPESIALIS_IGD`', 5, -1, FALSE, '`BIAYA_TARIF_DOKTER_SPESIALIS_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->Sortable = FALSE; // Allow sort
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TARIF_DOKTER_SPESIALIS_IGD'] = &$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD;

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_BIAYA_TARIF_DOKTER_KONSUL_IGD', 'BIAYA_TARIF_DOKTER_KONSUL_IGD', '`BIAYA_TARIF_DOKTER_KONSUL_IGD`', '`BIAYA_TARIF_DOKTER_KONSUL_IGD`', 5, -1, FALSE, '`BIAYA_TARIF_DOKTER_KONSUL_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->Sortable = FALSE; // Allow sort
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['BIAYA_TARIF_DOKTER_KONSUL_IGD'] = &$this->BIAYA_TARIF_DOKTER_KONSUL_IGD;

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_MAKAN_IGD', 'TARIF_MAKAN_IGD', '`TARIF_MAKAN_IGD`', '`TARIF_MAKAN_IGD`', 5, -1, FALSE, '`TARIF_MAKAN_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_MAKAN_IGD->Sortable = FALSE; // Allow sort
		$this->TARIF_MAKAN_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_MAKAN_IGD'] = &$this->TARIF_MAKAN_IGD;

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_ASUHAN_KEPERAWATAN_IGD', 'TARIF_ASUHAN_KEPERAWATAN_IGD', '`TARIF_ASUHAN_KEPERAWATAN_IGD`', '`TARIF_ASUHAN_KEPERAWATAN_IGD`', 5, -1, FALSE, '`TARIF_ASUHAN_KEPERAWATAN_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->Sortable = FALSE; // Allow sort
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_ASUHAN_KEPERAWATAN_IGD'] = &$this->TARIF_ASUHAN_KEPERAWATAN_IGD;

		// pasien_TITLE
		$this->pasien_TITLE = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_TITLE', 'pasien_TITLE', '`pasien_TITLE`', '`pasien_TITLE`', 200, -1, FALSE, '`pasien_TITLE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pasien_TITLE->Sortable = FALSE; // Allow sort
		$this->pasien_TITLE->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->pasien_TITLE->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['pasien_TITLE'] = &$this->pasien_TITLE;

		// pasien_NAMA
		$this->pasien_NAMA = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_NAMA', 'pasien_NAMA', '`pasien_NAMA`', '`pasien_NAMA`', 200, -1, FALSE, '`pasien_NAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_NAMA->Sortable = FALSE; // Allow sort
		$this->fields['pasien_NAMA'] = &$this->pasien_NAMA;

		// pasien_TEMPAT
		$this->pasien_TEMPAT = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_TEMPAT', 'pasien_TEMPAT', '`pasien_TEMPAT`', '`pasien_TEMPAT`', 200, -1, FALSE, '`pasien_TEMPAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_TEMPAT->Sortable = FALSE; // Allow sort
		$this->fields['pasien_TEMPAT'] = &$this->pasien_TEMPAT;

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_TGLLAHIR', 'pasien_TGLLAHIR', '`pasien_TGLLAHIR`', ew_CastDateFieldForLike('`pasien_TGLLAHIR`', 7, "DB"), 135, 7, FALSE, '`pasien_TGLLAHIR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_TGLLAHIR->Sortable = FALSE; // Allow sort
		$this->pasien_TGLLAHIR->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['pasien_TGLLAHIR'] = &$this->pasien_TGLLAHIR;

		// pasien_JENISKELAMIN
		$this->pasien_JENISKELAMIN = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_JENISKELAMIN', 'pasien_JENISKELAMIN', '`pasien_JENISKELAMIN`', '`pasien_JENISKELAMIN`', 200, -1, FALSE, '`pasien_JENISKELAMIN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->pasien_JENISKELAMIN->Sortable = FALSE; // Allow sort
		$this->fields['pasien_JENISKELAMIN'] = &$this->pasien_JENISKELAMIN;

		// pasien_ALAMAT
		$this->pasien_ALAMAT = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_ALAMAT', 'pasien_ALAMAT', '`pasien_ALAMAT`', '`pasien_ALAMAT`', 200, -1, FALSE, '`pasien_ALAMAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_ALAMAT->Sortable = FALSE; // Allow sort
		$this->fields['pasien_ALAMAT'] = &$this->pasien_ALAMAT;

		// pasien_KELURAHAN
		$this->pasien_KELURAHAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_KELURAHAN', 'pasien_KELURAHAN', '`pasien_KELURAHAN`', '`pasien_KELURAHAN`', 200, -1, FALSE, '`pasien_KELURAHAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_KELURAHAN->Sortable = FALSE; // Allow sort
		$this->fields['pasien_KELURAHAN'] = &$this->pasien_KELURAHAN;

		// pasien_KDKECAMATAN
		$this->pasien_KDKECAMATAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_KDKECAMATAN', 'pasien_KDKECAMATAN', '`pasien_KDKECAMATAN`', '`pasien_KDKECAMATAN`', 3, -1, FALSE, '`pasien_KDKECAMATAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_KDKECAMATAN->Sortable = FALSE; // Allow sort
		$this->pasien_KDKECAMATAN->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pasien_KDKECAMATAN'] = &$this->pasien_KDKECAMATAN;

		// pasien_KOTA
		$this->pasien_KOTA = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_KOTA', 'pasien_KOTA', '`pasien_KOTA`', '`pasien_KOTA`', 200, -1, FALSE, '`pasien_KOTA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_KOTA->Sortable = FALSE; // Allow sort
		$this->fields['pasien_KOTA'] = &$this->pasien_KOTA;

		// pasien_KDPROVINSI
		$this->pasien_KDPROVINSI = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_KDPROVINSI', 'pasien_KDPROVINSI', '`pasien_KDPROVINSI`', '`pasien_KDPROVINSI`', 3, -1, FALSE, '`pasien_KDPROVINSI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_KDPROVINSI->Sortable = FALSE; // Allow sort
		$this->pasien_KDPROVINSI->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pasien_KDPROVINSI'] = &$this->pasien_KDPROVINSI;

		// pasien_NOTELP
		$this->pasien_NOTELP = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_NOTELP', 'pasien_NOTELP', '`pasien_NOTELP`', '`pasien_NOTELP`', 200, -1, FALSE, '`pasien_NOTELP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_NOTELP->Sortable = FALSE; // Allow sort
		$this->fields['pasien_NOTELP'] = &$this->pasien_NOTELP;

		// pasien_NOKTP
		$this->pasien_NOKTP = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_NOKTP', 'pasien_NOKTP', '`pasien_NOKTP`', '`pasien_NOKTP`', 200, -1, FALSE, '`pasien_NOKTP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_NOKTP->Sortable = FALSE; // Allow sort
		$this->fields['pasien_NOKTP'] = &$this->pasien_NOKTP;

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_SUAMI_ORTU', 'pasien_SUAMI_ORTU', '`pasien_SUAMI_ORTU`', '`pasien_SUAMI_ORTU`', 200, -1, FALSE, '`pasien_SUAMI_ORTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_SUAMI_ORTU->Sortable = FALSE; // Allow sort
		$this->fields['pasien_SUAMI_ORTU'] = &$this->pasien_SUAMI_ORTU;

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_PEKERJAAN', 'pasien_PEKERJAAN', '`pasien_PEKERJAAN`', '`pasien_PEKERJAAN`', 200, -1, FALSE, '`pasien_PEKERJAAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_PEKERJAAN->Sortable = FALSE; // Allow sort
		$this->fields['pasien_PEKERJAAN'] = &$this->pasien_PEKERJAAN;

		// pasien_AGAMA
		$this->pasien_AGAMA = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_AGAMA', 'pasien_AGAMA', '`pasien_AGAMA`', '`pasien_AGAMA`', 3, -1, FALSE, '`pasien_AGAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pasien_AGAMA->Sortable = FALSE; // Allow sort
		$this->pasien_AGAMA->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->pasien_AGAMA->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->pasien_AGAMA->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pasien_AGAMA'] = &$this->pasien_AGAMA;

		// pasien_PENDIDIKAN
		$this->pasien_PENDIDIKAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_PENDIDIKAN', 'pasien_PENDIDIKAN', '`pasien_PENDIDIKAN`', '`pasien_PENDIDIKAN`', 3, -1, FALSE, '`pasien_PENDIDIKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pasien_PENDIDIKAN->Sortable = FALSE; // Allow sort
		$this->pasien_PENDIDIKAN->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->pasien_PENDIDIKAN->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->pasien_PENDIDIKAN->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pasien_PENDIDIKAN'] = &$this->pasien_PENDIDIKAN;

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_ALAMAT_KTP', 'pasien_ALAMAT_KTP', '`pasien_ALAMAT_KTP`', '`pasien_ALAMAT_KTP`', 200, -1, FALSE, '`pasien_ALAMAT_KTP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_ALAMAT_KTP->Sortable = FALSE; // Allow sort
		$this->fields['pasien_ALAMAT_KTP'] = &$this->pasien_ALAMAT_KTP;

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_NO_KARTU', 'pasien_NO_KARTU', '`pasien_NO_KARTU`', '`pasien_NO_KARTU`', 200, -1, FALSE, '`pasien_NO_KARTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_NO_KARTU->Sortable = FALSE; // Allow sort
		$this->fields['pasien_NO_KARTU'] = &$this->pasien_NO_KARTU;

		// pasien_JNS_PASIEN
		$this->pasien_JNS_PASIEN = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_JNS_PASIEN', 'pasien_JNS_PASIEN', '`pasien_JNS_PASIEN`', '`pasien_JNS_PASIEN`', 200, -1, FALSE, '`pasien_JNS_PASIEN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pasien_JNS_PASIEN->Sortable = FALSE; // Allow sort
		$this->pasien_JNS_PASIEN->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->pasien_JNS_PASIEN->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['pasien_JNS_PASIEN'] = &$this->pasien_JNS_PASIEN;

		// pasien_nama_ayah
		$this->pasien_nama_ayah = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_nama_ayah', 'pasien_nama_ayah', '`pasien_nama_ayah`', '`pasien_nama_ayah`', 200, -1, FALSE, '`pasien_nama_ayah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_nama_ayah->Sortable = FALSE; // Allow sort
		$this->fields['pasien_nama_ayah'] = &$this->pasien_nama_ayah;

		// pasien_nama_ibu
		$this->pasien_nama_ibu = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_nama_ibu', 'pasien_nama_ibu', '`pasien_nama_ibu`', '`pasien_nama_ibu`', 200, -1, FALSE, '`pasien_nama_ibu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_nama_ibu->Sortable = FALSE; // Allow sort
		$this->fields['pasien_nama_ibu'] = &$this->pasien_nama_ibu;

		// pasien_nama_suami
		$this->pasien_nama_suami = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_nama_suami', 'pasien_nama_suami', '`pasien_nama_suami`', '`pasien_nama_suami`', 200, -1, FALSE, '`pasien_nama_suami`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_nama_suami->Sortable = FALSE; // Allow sort
		$this->fields['pasien_nama_suami'] = &$this->pasien_nama_suami;

		// pasien_nama_istri
		$this->pasien_nama_istri = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_nama_istri', 'pasien_nama_istri', '`pasien_nama_istri`', '`pasien_nama_istri`', 200, -1, FALSE, '`pasien_nama_istri`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_nama_istri->Sortable = FALSE; // Allow sort
		$this->fields['pasien_nama_istri'] = &$this->pasien_nama_istri;

		// pasien_KD_ETNIS
		$this->pasien_KD_ETNIS = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_KD_ETNIS', 'pasien_KD_ETNIS', '`pasien_KD_ETNIS`', '`pasien_KD_ETNIS`', 3, -1, FALSE, '`pasien_KD_ETNIS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pasien_KD_ETNIS->Sortable = FALSE; // Allow sort
		$this->pasien_KD_ETNIS->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->pasien_KD_ETNIS->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->pasien_KD_ETNIS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pasien_KD_ETNIS'] = &$this->pasien_KD_ETNIS;

		// pasien_KD_BHS_HARIAN
		$this->pasien_KD_BHS_HARIAN = new cField('t_pendaftaran', 't_pendaftaran', 'x_pasien_KD_BHS_HARIAN', 'pasien_KD_BHS_HARIAN', '`pasien_KD_BHS_HARIAN`', '`pasien_KD_BHS_HARIAN`', 3, -1, FALSE, '`pasien_KD_BHS_HARIAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pasien_KD_BHS_HARIAN->Sortable = FALSE; // Allow sort
		$this->pasien_KD_BHS_HARIAN->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->pasien_KD_BHS_HARIAN->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->pasien_KD_BHS_HARIAN->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pasien_KD_BHS_HARIAN'] = &$this->pasien_KD_BHS_HARIAN;

		// BILL_FARMASI_SELESAI
		$this->BILL_FARMASI_SELESAI = new cField('t_pendaftaran', 't_pendaftaran', 'x_BILL_FARMASI_SELESAI', 'BILL_FARMASI_SELESAI', '`BILL_FARMASI_SELESAI`', '`BILL_FARMASI_SELESAI`', 3, -1, FALSE, '`BILL_FARMASI_SELESAI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BILL_FARMASI_SELESAI->Sortable = FALSE; // Allow sort
		$this->BILL_FARMASI_SELESAI->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['BILL_FARMASI_SELESAI'] = &$this->BILL_FARMASI_SELESAI;

		// TARIF_PELAYANAN_SIMRS
		$this->TARIF_PELAYANAN_SIMRS = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_PELAYANAN_SIMRS', 'TARIF_PELAYANAN_SIMRS', '`TARIF_PELAYANAN_SIMRS`', '`TARIF_PELAYANAN_SIMRS`', 5, -1, FALSE, '`TARIF_PELAYANAN_SIMRS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_PELAYANAN_SIMRS->Sortable = FALSE; // Allow sort
		$this->TARIF_PELAYANAN_SIMRS->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_PELAYANAN_SIMRS'] = &$this->TARIF_PELAYANAN_SIMRS;

		// USER_ADM
		$this->USER_ADM = new cField('t_pendaftaran', 't_pendaftaran', 'x_USER_ADM', 'USER_ADM', '`USER_ADM`', '`USER_ADM`', 200, -1, FALSE, '`USER_ADM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER_ADM->Sortable = FALSE; // Allow sort
		$this->fields['USER_ADM'] = &$this->USER_ADM;

		// TARIF_PENUNJANG_NON_MEDIS_IGD
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_PENUNJANG_NON_MEDIS_IGD', 'TARIF_PENUNJANG_NON_MEDIS_IGD', '`TARIF_PENUNJANG_NON_MEDIS_IGD`', '`TARIF_PENUNJANG_NON_MEDIS_IGD`', 5, -1, FALSE, '`TARIF_PENUNJANG_NON_MEDIS_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->Sortable = FALSE; // Allow sort
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_PENUNJANG_NON_MEDIS_IGD'] = &$this->TARIF_PENUNJANG_NON_MEDIS_IGD;

		// TARIF_PELAYANAN_DARAH
		$this->TARIF_PELAYANAN_DARAH = new cField('t_pendaftaran', 't_pendaftaran', 'x_TARIF_PELAYANAN_DARAH', 'TARIF_PELAYANAN_DARAH', '`TARIF_PELAYANAN_DARAH`', '`TARIF_PELAYANAN_DARAH`', 5, -1, FALSE, '`TARIF_PELAYANAN_DARAH`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TARIF_PELAYANAN_DARAH->Sortable = FALSE; // Allow sort
		$this->TARIF_PELAYANAN_DARAH->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TARIF_PELAYANAN_DARAH'] = &$this->TARIF_PELAYANAN_DARAH;

		// penjamin_kkl_id
		$this->penjamin_kkl_id = new cField('t_pendaftaran', 't_pendaftaran', 'x_penjamin_kkl_id', 'penjamin_kkl_id', '`penjamin_kkl_id`', '`penjamin_kkl_id`', 3, -1, FALSE, '`penjamin_kkl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->penjamin_kkl_id->Sortable = FALSE; // Allow sort
		$this->penjamin_kkl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['penjamin_kkl_id'] = &$this->penjamin_kkl_id;

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id = new cField('t_pendaftaran', 't_pendaftaran', 'x_asalfaskesrujukan_id', 'asalfaskesrujukan_id', '`asalfaskesrujukan_id`', '`asalfaskesrujukan_id`', 3, -1, FALSE, '`asalfaskesrujukan_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->asalfaskesrujukan_id->Sortable = FALSE; // Allow sort
		$this->asalfaskesrujukan_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['asalfaskesrujukan_id'] = &$this->asalfaskesrujukan_id;

		// peserta_cob
		$this->peserta_cob = new cField('t_pendaftaran', 't_pendaftaran', 'x_peserta_cob', 'peserta_cob', '`peserta_cob`', '`peserta_cob`', 3, -1, FALSE, '`peserta_cob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->peserta_cob->Sortable = TRUE; // Allow sort
		$this->peserta_cob->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['peserta_cob'] = &$this->peserta_cob;

		// poli_eksekutif
		$this->poli_eksekutif = new cField('t_pendaftaran', 't_pendaftaran', 'x_poli_eksekutif', 'poli_eksekutif', '`poli_eksekutif`', '`poli_eksekutif`', 3, -1, FALSE, '`poli_eksekutif`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->poli_eksekutif->Sortable = TRUE; // Allow sort
		$this->poli_eksekutif->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['poli_eksekutif'] = &$this->poli_eksekutif;

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS = new cField('t_pendaftaran', 't_pendaftaran', 'x_status_kepesertaan_BPJS', 'status_kepesertaan_BPJS', '`status_kepesertaan_BPJS`', '`status_kepesertaan_BPJS`', 200, -1, FALSE, '`status_kepesertaan_BPJS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_kepesertaan_BPJS->Sortable = FALSE; // Allow sort
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_pendaftaran`";
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
			return "t_pendaftaranlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_pendaftaranlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_pendaftaranview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_pendaftaranview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_pendaftaranadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_pendaftaranadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t_pendaftaranedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t_pendaftaranadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_pendaftarandelete.php", $this->UrlParm());
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
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NOJAMINAN->setDbValue($rs->fields('NOJAMINAN'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->KETERANGAN_STATUS->setDbValue($rs->fields('KETERANGAN_STATUS'));
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
		$this->TOTAL_BIAYA_OBAT->setDbValue($rs->fields('TOTAL_BIAYA_OBAT'));
		$this->biaya_obat->setDbValue($rs->fields('biaya_obat'));
		$this->biaya_retur_obat->setDbValue($rs->fields('biaya_retur_obat'));
		$this->TOTAL_BIAYA_OBAT_RAJAL->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_RAJAL'));
		$this->biaya_obat_rajal->setDbValue($rs->fields('biaya_obat_rajal'));
		$this->biaya_retur_obat_rajal->setDbValue($rs->fields('biaya_retur_obat_rajal'));
		$this->TOTAL_BIAYA_OBAT_IGD->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_IGD'));
		$this->biaya_obat_igd->setDbValue($rs->fields('biaya_obat_igd'));
		$this->biaya_retur_obat_igd->setDbValue($rs->fields('biaya_retur_obat_igd'));
		$this->TOTAL_BIAYA_OBAT_IBS->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_IBS'));
		$this->biaya_obat_ibs->setDbValue($rs->fields('biaya_obat_ibs'));
		$this->biaya_retur_obat_ibs->setDbValue($rs->fields('biaya_retur_obat_ibs'));
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
		$this->cek_data_kepesertaan->setDbValue($rs->fields('cek_data_kepesertaan'));
		$this->generate_sep->setDbValue($rs->fields('generate_sep'));
		$this->PESERTANIK_SEP->setDbValue($rs->fields('PESERTANIK_SEP'));
		$this->PESERTANAMA_SEP->setDbValue($rs->fields('PESERTANAMA_SEP'));
		$this->PESERTAJENISKELAMIN_SEP->setDbValue($rs->fields('PESERTAJENISKELAMIN_SEP'));
		$this->PESERTANAMAKELAS_SEP->setDbValue($rs->fields('PESERTANAMAKELAS_SEP'));
		$this->PESERTAPISAT->setDbValue($rs->fields('PESERTAPISAT'));
		$this->PESERTATGLLAHIR->setDbValue($rs->fields('PESERTATGLLAHIR'));
		$this->PESERTAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTAJENISPESERTA_SEP'));
		$this->PESERTANAMAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTANAMAJENISPESERTA_SEP'));
		$this->PESERTATGLCETAKKARTU_SEP->setDbValue($rs->fields('PESERTATGLCETAKKARTU_SEP'));
		$this->POLITUJUAN_SEP->setDbValue($rs->fields('POLITUJUAN_SEP'));
		$this->NAMAPOLITUJUAN_SEP->setDbValue($rs->fields('NAMAPOLITUJUAN_SEP'));
		$this->KDPPKRUJUKAN_SEP->setDbValue($rs->fields('KDPPKRUJUKAN_SEP'));
		$this->NMPPKRUJUKAN_SEP->setDbValue($rs->fields('NMPPKRUJUKAN_SEP'));
		$this->UPDATETGLPLNG_SEP->setDbValue($rs->fields('UPDATETGLPLNG_SEP'));
		$this->bridging_upt_tglplng->setDbValue($rs->fields('bridging_upt_tglplng'));
		$this->mapingtransaksi->setDbValue($rs->fields('mapingtransaksi'));
		$this->bridging_no_rujukan->setDbValue($rs->fields('bridging_no_rujukan'));
		$this->bridging_hapus_sep->setDbValue($rs->fields('bridging_hapus_sep'));
		$this->bridging_kepesertaan_by_no_ka->setDbValue($rs->fields('bridging_kepesertaan_by_no_ka'));
		$this->NOKARTU_BPJS->setDbValue($rs->fields('NOKARTU_BPJS'));
		$this->counter_cetak_kartu->setDbValue($rs->fields('counter_cetak_kartu'));
		$this->bridging_kepesertaan_by_nik->setDbValue($rs->fields('bridging_kepesertaan_by_nik'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->bridging_by_no_rujukan->setDbValue($rs->fields('bridging_by_no_rujukan'));
		$this->maping_hapus_sep->setDbValue($rs->fields('maping_hapus_sep'));
		$this->counter_cetak_kartu_ranap->setDbValue($rs->fields('counter_cetak_kartu_ranap'));
		$this->BIAYA_PENDAFTARAN->setDbValue($rs->fields('BIAYA_PENDAFTARAN'));
		$this->BIAYA_TINDAKAN_POLI->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI'));
		$this->BIAYA_TINDAKAN_RADIOLOGI->setDbValue($rs->fields('BIAYA_TINDAKAN_RADIOLOGI'));
		$this->BIAYA_TINDAKAN_LABORAT->setDbValue($rs->fields('BIAYA_TINDAKAN_LABORAT'));
		$this->BIAYA_TINDAKAN_KONSULTASI->setDbValue($rs->fields('BIAYA_TINDAKAN_KONSULTASI'));
		$this->BIAYA_TARIF_DOKTER->setDbValue($rs->fields('BIAYA_TARIF_DOKTER'));
		$this->BIAYA_TARIF_DOKTER_KONSUL->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_KONSUL'));
		$this->INCLUDE->setDbValue($rs->fields('INCLUDE'));
		$this->eklaim_kelas_rawat_rajal->setDbValue($rs->fields('eklaim_kelas_rawat_rajal'));
		$this->eklaim_adl_score->setDbValue($rs->fields('eklaim_adl_score'));
		$this->eklaim_adl_sub_acute->setDbValue($rs->fields('eklaim_adl_sub_acute'));
		$this->eklaim_adl_chronic->setDbValue($rs->fields('eklaim_adl_chronic'));
		$this->eklaim_icu_indikator->setDbValue($rs->fields('eklaim_icu_indikator'));
		$this->eklaim_icu_los->setDbValue($rs->fields('eklaim_icu_los'));
		$this->eklaim_ventilator_hour->setDbValue($rs->fields('eklaim_ventilator_hour'));
		$this->eklaim_upgrade_class_ind->setDbValue($rs->fields('eklaim_upgrade_class_ind'));
		$this->eklaim_upgrade_class_class->setDbValue($rs->fields('eklaim_upgrade_class_class'));
		$this->eklaim_upgrade_class_los->setDbValue($rs->fields('eklaim_upgrade_class_los'));
		$this->eklaim_birth_weight->setDbValue($rs->fields('eklaim_birth_weight'));
		$this->eklaim_discharge_status->setDbValue($rs->fields('eklaim_discharge_status'));
		$this->eklaim_diagnosa->setDbValue($rs->fields('eklaim_diagnosa'));
		$this->eklaim_procedure->setDbValue($rs->fields('eklaim_procedure'));
		$this->eklaim_tarif_rs->setDbValue($rs->fields('eklaim_tarif_rs'));
		$this->eklaim_tarif_poli_eks->setDbValue($rs->fields('eklaim_tarif_poli_eks'));
		$this->eklaim_id_dokter->setDbValue($rs->fields('eklaim_id_dokter'));
		$this->eklaim_nama_dokter->setDbValue($rs->fields('eklaim_nama_dokter'));
		$this->eklaim_kode_tarif->setDbValue($rs->fields('eklaim_kode_tarif'));
		$this->eklaim_payor_id->setDbValue($rs->fields('eklaim_payor_id'));
		$this->eklaim_payor_cd->setDbValue($rs->fields('eklaim_payor_cd'));
		$this->eklaim_coder_nik->setDbValue($rs->fields('eklaim_coder_nik'));
		$this->eklaim_los->setDbValue($rs->fields('eklaim_los'));
		$this->eklaim_patient_id->setDbValue($rs->fields('eklaim_patient_id'));
		$this->eklaim_admission_id->setDbValue($rs->fields('eklaim_admission_id'));
		$this->eklaim_hospital_admission_id->setDbValue($rs->fields('eklaim_hospital_admission_id'));
		$this->bridging_hapussep->setDbValue($rs->fields('bridging_hapussep'));
		$this->user_penghapus_sep->setDbValue($rs->fields('user_penghapus_sep'));
		$this->BIAYA_BILLING_RAJAL->setDbValue($rs->fields('BIAYA_BILLING_RAJAL'));
		$this->STATUS_PEMBAYARAN->setDbValue($rs->fields('STATUS_PEMBAYARAN'));
		$this->BIAYA_TINDAKAN_FISIOTERAPI->setDbValue($rs->fields('BIAYA_TINDAKAN_FISIOTERAPI'));
		$this->eklaim_reg_pasien->setDbValue($rs->fields('eklaim_reg_pasien'));
		$this->eklaim_reg_klaim_baru->setDbValue($rs->fields('eklaim_reg_klaim_baru'));
		$this->eklaim_gruper1->setDbValue($rs->fields('eklaim_gruper1'));
		$this->eklaim_gruper2->setDbValue($rs->fields('eklaim_gruper2'));
		$this->eklaim_finalklaim->setDbValue($rs->fields('eklaim_finalklaim'));
		$this->eklaim_sendklaim->setDbValue($rs->fields('eklaim_sendklaim'));
		$this->eklaim_flag_hapus_pasien->setDbValue($rs->fields('eklaim_flag_hapus_pasien'));
		$this->eklaim_flag_hapus_klaim->setDbValue($rs->fields('eklaim_flag_hapus_klaim'));
		$this->eklaim_kemkes_dc_Status->setDbValue($rs->fields('eklaim_kemkes_dc_Status'));
		$this->eklaim_bpjs_dc_Status->setDbValue($rs->fields('eklaim_bpjs_dc_Status'));
		$this->eklaim_cbg_code->setDbValue($rs->fields('eklaim_cbg_code'));
		$this->eklaim_cbg_descprition->setDbValue($rs->fields('eklaim_cbg_descprition'));
		$this->eklaim_cbg_tariff->setDbValue($rs->fields('eklaim_cbg_tariff'));
		$this->eklaim_sub_acute_code->setDbValue($rs->fields('eklaim_sub_acute_code'));
		$this->eklaim_sub_acute_deskripsi->setDbValue($rs->fields('eklaim_sub_acute_deskripsi'));
		$this->eklaim_sub_acute_tariff->setDbValue($rs->fields('eklaim_sub_acute_tariff'));
		$this->eklaim_chronic_code->setDbValue($rs->fields('eklaim_chronic_code'));
		$this->eklaim_chronic_deskripsi->setDbValue($rs->fields('eklaim_chronic_deskripsi'));
		$this->eklaim_chronic_tariff->setDbValue($rs->fields('eklaim_chronic_tariff'));
		$this->eklaim_inacbg_version->setDbValue($rs->fields('eklaim_inacbg_version'));
		$this->BIAYA_TINDAKAN_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_IBS_RAJAL'));
		$this->VERIFY_ICD->setDbValue($rs->fields('VERIFY_ICD'));
		$this->bridging_rujukan_faskes_2->setDbValue($rs->fields('bridging_rujukan_faskes_2'));
		$this->eklaim_reedit_claim->setDbValue($rs->fields('eklaim_reedit_claim'));
		$this->KETERANGAN->setDbValue($rs->fields('KETERANGAN'));
		$this->TGLLAHIR->setDbValue($rs->fields('TGLLAHIR'));
		$this->USER_KASIR->setDbValue($rs->fields('USER_KASIR'));
		$this->eklaim_tgl_gruping->setDbValue($rs->fields('eklaim_tgl_gruping'));
		$this->eklaim_tgl_finalklaim->setDbValue($rs->fields('eklaim_tgl_finalklaim'));
		$this->eklaim_tgl_kirim_klaim->setDbValue($rs->fields('eklaim_tgl_kirim_klaim'));
		$this->BIAYA_OBAT_RS->setDbValue($rs->fields('BIAYA_OBAT_RS'));
		$this->EKG_RAJAL->setDbValue($rs->fields('EKG_RAJAL'));
		$this->USG_RAJAL->setDbValue($rs->fields('USG_RAJAL'));
		$this->FISIOTERAPI_RAJAL->setDbValue($rs->fields('FISIOTERAPI_RAJAL'));
		$this->BHP_RAJAL->setDbValue($rs->fields('BHP_RAJAL'));
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_ASKEP_IBS_RAJAL'));
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_TMNO_IBS_RAJAL'));
		$this->TOTAL_BIAYA_IBS_RAJAL->setDbValue($rs->fields('TOTAL_BIAYA_IBS_RAJAL'));
		$this->ORDER_LAB->setDbValue($rs->fields('ORDER_LAB'));
		$this->BILL_RAJAL_SELESAI->setDbValue($rs->fields('BILL_RAJAL_SELESAI'));
		$this->INCLUDE_IDXDAFTAR->setDbValue($rs->fields('INCLUDE_IDXDAFTAR'));
		$this->INCLUDE_HARGA->setDbValue($rs->fields('INCLUDE_HARGA'));
		$this->TARIF_JASA_SARANA->setDbValue($rs->fields('TARIF_JASA_SARANA'));
		$this->TARIF_PENUNJANG_NON_MEDIS->setDbValue($rs->fields('TARIF_PENUNJANG_NON_MEDIS'));
		$this->TARIF_ASUHAN_KEPERAWATAN->setDbValue($rs->fields('TARIF_ASUHAN_KEPERAWATAN'));
		$this->KDDOKTER_RAJAL->setDbValue($rs->fields('KDDOKTER_RAJAL'));
		$this->KDDOKTER_KONSUL_RAJAL->setDbValue($rs->fields('KDDOKTER_KONSUL_RAJAL'));
		$this->BIAYA_BILLING_RS->setDbValue($rs->fields('BIAYA_BILLING_RS'));
		$this->BIAYA_TINDAKAN_POLI_TMO->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_TMO'));
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_KEPERAWATAN'));
		$this->BHP_RAJAL_TMO->setDbValue($rs->fields('BHP_RAJAL_TMO'));
		$this->BHP_RAJAL_KEPERAWATAN->setDbValue($rs->fields('BHP_RAJAL_KEPERAWATAN'));
		$this->TARIF_AKOMODASI->setDbValue($rs->fields('TARIF_AKOMODASI'));
		$this->TARIF_AMBULAN->setDbValue($rs->fields('TARIF_AMBULAN'));
		$this->TARIF_OKSIGEN->setDbValue($rs->fields('TARIF_OKSIGEN'));
		$this->BIAYA_TINDAKAN_JENAZAH->setDbValue($rs->fields('BIAYA_TINDAKAN_JENAZAH'));
		$this->BIAYA_BILLING_IGD->setDbValue($rs->fields('BIAYA_BILLING_IGD'));
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_PERSALINAN'));
		$this->BHP_RAJAL_PERSALINAN->setDbValue($rs->fields('BHP_RAJAL_PERSALINAN'));
		$this->TARIF_BIMBINGAN_ROHANI->setDbValue($rs->fields('TARIF_BIMBINGAN_ROHANI'));
		$this->BIAYA_BILLING_RS2->setDbValue($rs->fields('BIAYA_BILLING_RS2'));
		$this->BIAYA_TARIF_DOKTER_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_IGD'));
		$this->BIAYA_PENDAFTARAN_IGD->setDbValue($rs->fields('BIAYA_PENDAFTARAN_IGD'));
		$this->BIAYA_BILLING_IBS->setDbValue($rs->fields('BIAYA_BILLING_IBS'));
		$this->TARIF_JASA_SARANA_IGD->setDbValue($rs->fields('TARIF_JASA_SARANA_IGD'));
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_SPESIALIS_IGD'));
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_KONSUL_IGD'));
		$this->TARIF_MAKAN_IGD->setDbValue($rs->fields('TARIF_MAKAN_IGD'));
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->setDbValue($rs->fields('TARIF_ASUHAN_KEPERAWATAN_IGD'));
		$this->pasien_TITLE->setDbValue($rs->fields('pasien_TITLE'));
		$this->pasien_NAMA->setDbValue($rs->fields('pasien_NAMA'));
		$this->pasien_TEMPAT->setDbValue($rs->fields('pasien_TEMPAT'));
		$this->pasien_TGLLAHIR->setDbValue($rs->fields('pasien_TGLLAHIR'));
		$this->pasien_JENISKELAMIN->setDbValue($rs->fields('pasien_JENISKELAMIN'));
		$this->pasien_ALAMAT->setDbValue($rs->fields('pasien_ALAMAT'));
		$this->pasien_KELURAHAN->setDbValue($rs->fields('pasien_KELURAHAN'));
		$this->pasien_KDKECAMATAN->setDbValue($rs->fields('pasien_KDKECAMATAN'));
		$this->pasien_KOTA->setDbValue($rs->fields('pasien_KOTA'));
		$this->pasien_KDPROVINSI->setDbValue($rs->fields('pasien_KDPROVINSI'));
		$this->pasien_NOTELP->setDbValue($rs->fields('pasien_NOTELP'));
		$this->pasien_NOKTP->setDbValue($rs->fields('pasien_NOKTP'));
		$this->pasien_SUAMI_ORTU->setDbValue($rs->fields('pasien_SUAMI_ORTU'));
		$this->pasien_PEKERJAAN->setDbValue($rs->fields('pasien_PEKERJAAN'));
		$this->pasien_AGAMA->setDbValue($rs->fields('pasien_AGAMA'));
		$this->pasien_PENDIDIKAN->setDbValue($rs->fields('pasien_PENDIDIKAN'));
		$this->pasien_ALAMAT_KTP->setDbValue($rs->fields('pasien_ALAMAT_KTP'));
		$this->pasien_NO_KARTU->setDbValue($rs->fields('pasien_NO_KARTU'));
		$this->pasien_JNS_PASIEN->setDbValue($rs->fields('pasien_JNS_PASIEN'));
		$this->pasien_nama_ayah->setDbValue($rs->fields('pasien_nama_ayah'));
		$this->pasien_nama_ibu->setDbValue($rs->fields('pasien_nama_ibu'));
		$this->pasien_nama_suami->setDbValue($rs->fields('pasien_nama_suami'));
		$this->pasien_nama_istri->setDbValue($rs->fields('pasien_nama_istri'));
		$this->pasien_KD_ETNIS->setDbValue($rs->fields('pasien_KD_ETNIS'));
		$this->pasien_KD_BHS_HARIAN->setDbValue($rs->fields('pasien_KD_BHS_HARIAN'));
		$this->BILL_FARMASI_SELESAI->setDbValue($rs->fields('BILL_FARMASI_SELESAI'));
		$this->TARIF_PELAYANAN_SIMRS->setDbValue($rs->fields('TARIF_PELAYANAN_SIMRS'));
		$this->USER_ADM->setDbValue($rs->fields('USER_ADM'));
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->setDbValue($rs->fields('TARIF_PENUNJANG_NON_MEDIS_IGD'));
		$this->TARIF_PELAYANAN_DARAH->setDbValue($rs->fields('TARIF_PELAYANAN_DARAH'));
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

		$this->IDXDAFTAR->CellCssStyle = "white-space: nowrap;";

		// PASIENBARU
		$this->PASIENBARU->CellCssStyle = "white-space: nowrap;";

		// NOMR
		$this->NOMR->CellCssStyle = "white-space: nowrap;";

		// TGLREG
		$this->TGLREG->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER
		$this->KDDOKTER->CellCssStyle = "white-space: nowrap;";

		// KDPOLY
		$this->KDPOLY->CellCssStyle = "white-space: nowrap;";

		// KDRUJUK
		$this->KDRUJUK->CellCssStyle = "white-space: nowrap;";

		// KDCARABAYAR
		$this->KDCARABAYAR->CellCssStyle = "white-space: nowrap;";

		// NOJAMINAN
		$this->NOJAMINAN->CellCssStyle = "white-space: nowrap;";

		// SHIFT
		$this->SHIFT->CellCssStyle = "white-space: nowrap;";

		// STATUS
		$this->STATUS->CellCssStyle = "white-space: nowrap;";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->CellCssStyle = "white-space: nowrap;";

		// NIP
		$this->NIP->CellCssStyle = "white-space: nowrap;";

		// MASUKPOLY
		$this->MASUKPOLY->CellCssStyle = "white-space: nowrap;";

		// KELUARPOLY
		$this->KELUARPOLY->CellCssStyle = "white-space: nowrap;";

		// KETRUJUK
		$this->KETRUJUK->CellCssStyle = "white-space: nowrap;";

		// KETBAYAR
		$this->KETBAYAR->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->CellCssStyle = "white-space: nowrap;";

		// JAMREG
		$this->JAMREG->CellCssStyle = "white-space: nowrap;";

		// BATAL
		$this->BATAL->CellCssStyle = "white-space: nowrap;";

		// NO_SJP
		$this->NO_SJP->CellCssStyle = "white-space: nowrap;";

		// NO_PESERTA
		$this->NO_PESERTA->CellCssStyle = "white-space: nowrap;";

		// NOKARTU
		$this->NOKARTU->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->CellCssStyle = "white-space: nowrap;";

		// biaya_obat
		$this->biaya_obat->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat
		$this->biaya_retur_obat->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_rajal
		$this->biaya_obat_rajal->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_igd
		$this->biaya_obat_igd->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_ibs
		$this->biaya_obat_ibs->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs->CellCssStyle = "white-space: nowrap;";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->CellCssStyle = "white-space: nowrap;";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->CellCssStyle = "white-space: nowrap;";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->CellCssStyle = "white-space: nowrap;";

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->CellCssStyle = "white-space: nowrap;";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->CellCssStyle = "white-space: nowrap;";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->CellCssStyle = "white-space: nowrap;";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->CellCssStyle = "white-space: nowrap;";

		// CATATAN_SEP
		$this->CATATAN_SEP->CellCssStyle = "white-space: nowrap;";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->CellCssStyle = "white-space: nowrap;";

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->CellCssStyle = "white-space: nowrap;";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->CellCssStyle = "white-space: nowrap;";

		// USER
		$this->USER->CellCssStyle = "white-space: nowrap;";

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan->CellCssStyle = "white-space: nowrap;";

		// generate_sep
		$this->generate_sep->CellCssStyle = "white-space: nowrap;";

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTAPISAT
		$this->PESERTAPISAT->CellCssStyle = "white-space: nowrap;";

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP->CellCssStyle = "white-space: nowrap;";

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->CellCssStyle = "white-space: nowrap;";

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP->CellCssStyle = "white-space: nowrap;";

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng->CellCssStyle = "white-space: nowrap;";

		// mapingtransaksi
		$this->mapingtransaksi->CellCssStyle = "white-space: nowrap;";

		// bridging_no_rujukan
		$this->bridging_no_rujukan->CellCssStyle = "white-space: nowrap;";

		// bridging_hapus_sep
		$this->bridging_hapus_sep->CellCssStyle = "white-space: nowrap;";

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->CellCssStyle = "white-space: nowrap;";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->CellCssStyle = "white-space: nowrap;";

		// counter_cetak_kartu
		$this->counter_cetak_kartu->CellCssStyle = "white-space: nowrap;";

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik->CellCssStyle = "white-space: nowrap;";

		// NOKTP
		$this->NOKTP->CellCssStyle = "white-space: nowrap;";

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->CellCssStyle = "white-space: nowrap;";

		// maping_hapus_sep
		$this->maping_hapus_sep->CellCssStyle = "white-space: nowrap;";

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap->CellCssStyle = "white-space: nowrap;";

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL->CellCssStyle = "white-space: nowrap;";

		// INCLUDE
		$this->INCLUDE->CellCssStyle = "white-space: nowrap;";

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_score
		$this->eklaim_adl_score->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic->CellCssStyle = "white-space: nowrap;";

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator->CellCssStyle = "white-space: nowrap;";

		// eklaim_icu_los
		$this->eklaim_icu_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_birth_weight
		$this->eklaim_birth_weight->CellCssStyle = "white-space: nowrap;";

		// eklaim_discharge_status
		$this->eklaim_discharge_status->CellCssStyle = "white-space: nowrap;";

		// eklaim_diagnosa
		$this->eklaim_diagnosa->CellCssStyle = "white-space: nowrap;";

		// eklaim_procedure
		$this->eklaim_procedure->CellCssStyle = "white-space: nowrap;";

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs->CellCssStyle = "white-space: nowrap;";

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks->CellCssStyle = "white-space: nowrap;";

		// eklaim_id_dokter
		$this->eklaim_id_dokter->CellCssStyle = "white-space: nowrap;";

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter->CellCssStyle = "white-space: nowrap;";

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif->CellCssStyle = "white-space: nowrap;";

		// eklaim_payor_id
		$this->eklaim_payor_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_payor_cd
		$this->eklaim_payor_cd->CellCssStyle = "white-space: nowrap;";

		// eklaim_coder_nik
		$this->eklaim_coder_nik->CellCssStyle = "white-space: nowrap;";

		// eklaim_los
		$this->eklaim_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_patient_id
		$this->eklaim_patient_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_admission_id
		$this->eklaim_admission_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id->CellCssStyle = "white-space: nowrap;";

		// bridging_hapussep
		$this->bridging_hapussep->CellCssStyle = "white-space: nowrap;";

		// user_penghapus_sep
		$this->user_penghapus_sep->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL->CellCssStyle = "white-space: nowrap;";

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI->CellCssStyle = "white-space: nowrap;";

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien->CellCssStyle = "white-space: nowrap;";

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru->CellCssStyle = "white-space: nowrap;";

		// eklaim_gruper1
		$this->eklaim_gruper1->CellCssStyle = "white-space: nowrap;";

		// eklaim_gruper2
		$this->eklaim_gruper2->CellCssStyle = "white-space: nowrap;";

		// eklaim_finalklaim
		$this->eklaim_finalklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_sendklaim
		$this->eklaim_sendklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien->CellCssStyle = "white-space: nowrap;";

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status->CellCssStyle = "white-space: nowrap;";

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_code
		$this->eklaim_cbg_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_code
		$this->eklaim_chronic_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// VERIFY_ICD
		$this->VERIFY_ICD->CellCssStyle = "white-space: nowrap;";

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->CellCssStyle = "white-space: nowrap;";

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim->CellCssStyle = "white-space: nowrap;";

		// KETERANGAN
		$this->KETERANGAN->CellCssStyle = "white-space: nowrap;";

		// TGLLAHIR
		$this->TGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// USER_KASIR
		$this->USER_KASIR->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim->CellCssStyle = "white-space: nowrap;";

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS->CellCssStyle = "white-space: nowrap;";

		// EKG_RAJAL
		$this->EKG_RAJAL->CellCssStyle = "white-space: nowrap;";

		// USG_RAJAL
		$this->USG_RAJAL->CellCssStyle = "white-space: nowrap;";

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL
		$this->BHP_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// ORDER_LAB
		$this->ORDER_LAB->CellCssStyle = "white-space: nowrap;";

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI->CellCssStyle = "white-space: nowrap;";

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR->CellCssStyle = "white-space: nowrap;";

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA->CellCssStyle = "white-space: nowrap;";

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA->CellCssStyle = "white-space: nowrap;";

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS->CellCssStyle = "white-space: nowrap;";

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI->CellCssStyle = "white-space: nowrap;";

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS->CellCssStyle = "white-space: nowrap;";

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->CellCssStyle = "white-space: nowrap;";

		// pasien_TITLE
		$this->pasien_TITLE->CellCssStyle = "white-space: nowrap;";

		// pasien_NAMA
		$this->pasien_NAMA->CellCssStyle = "white-space: nowrap;";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->CellCssStyle = "white-space: nowrap;";

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// pasien_JENISKELAMIN
		$this->pasien_JENISKELAMIN->CellCssStyle = "white-space: nowrap;";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->CellCssStyle = "white-space: nowrap;";

		// pasien_KELURAHAN
		$this->pasien_KELURAHAN->CellCssStyle = "white-space: nowrap;";

		// pasien_KDKECAMATAN
		$this->pasien_KDKECAMATAN->CellCssStyle = "white-space: nowrap;";

		// pasien_KOTA
		$this->pasien_KOTA->CellCssStyle = "white-space: nowrap;";

		// pasien_KDPROVINSI
		$this->pasien_KDPROVINSI->CellCssStyle = "white-space: nowrap;";

		// pasien_NOTELP
		$this->pasien_NOTELP->CellCssStyle = "white-space: nowrap;";

		// pasien_NOKTP
		$this->pasien_NOKTP->CellCssStyle = "white-space: nowrap;";

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU->CellCssStyle = "white-space: nowrap;";

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->CellCssStyle = "white-space: nowrap;";

		// pasien_AGAMA
		$this->pasien_AGAMA->CellCssStyle = "white-space: nowrap;";

		// pasien_PENDIDIKAN
		$this->pasien_PENDIDIKAN->CellCssStyle = "white-space: nowrap;";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->CellCssStyle = "white-space: nowrap;";

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->CellCssStyle = "white-space: nowrap;";

		// pasien_JNS_PASIEN
		$this->pasien_JNS_PASIEN->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_ibu
		$this->pasien_nama_ibu->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_suami
		$this->pasien_nama_suami->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_istri
		$this->pasien_nama_istri->CellCssStyle = "white-space: nowrap;";

		// pasien_KD_ETNIS
		$this->pasien_KD_ETNIS->CellCssStyle = "white-space: nowrap;";

		// pasien_KD_BHS_HARIAN
		$this->pasien_KD_BHS_HARIAN->CellCssStyle = "white-space: nowrap;";

		// BILL_FARMASI_SELESAI
		$this->BILL_FARMASI_SELESAI->CellCssStyle = "white-space: nowrap;";

		// TARIF_PELAYANAN_SIMRS
		$this->TARIF_PELAYANAN_SIMRS->CellCssStyle = "white-space: nowrap;";

		// USER_ADM
		$this->USER_ADM->CellCssStyle = "white-space: nowrap;";

		// TARIF_PENUNJANG_NON_MEDIS_IGD
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_PELAYANAN_DARAH
		$this->TARIF_PELAYANAN_DARAH->CellCssStyle = "white-space: nowrap;";

		// penjamin_kkl_id
		$this->penjamin_kkl_id->CellCssStyle = "white-space: nowrap;";

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->CellCssStyle = "white-space: nowrap;";

		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS

		$this->status_kepesertaan_BPJS->CellCssStyle = "white-space: nowrap;";

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// PASIENBARU
		if (strval($this->PASIENBARU->CurrentValue) <> "") {
			$this->PASIENBARU->ViewValue = $this->PASIENBARU->OptionCaption($this->PASIENBARU->CurrentValue);
		} else {
			$this->PASIENBARU->ViewValue = NULL;
		}
		$this->PASIENBARU->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 7);
		$this->TGLREG->ViewCustomAttributes = "";

		// KDDOKTER
		if (strval($this->KDDOKTER->CurrentValue) <> "") {
			$sFilterWrk = "`kddokter`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kddokter`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_lookup_dokter_poli`";
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
		if (strval($this->SHIFT->CurrentValue) <> "") {
			$sFilterWrk = "`id_shift`" . ew_SearchString("=", $this->SHIFT->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_shift`, `shift` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_shift`";
		$sWhereWrk = "";
		$this->SHIFT->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->SHIFT, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->SHIFT->ViewValue = $this->SHIFT->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
			}
		} else {
			$this->SHIFT->ViewValue = NULL;
		}
		$this->SHIFT->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->ViewValue = $this->KETERANGAN_STATUS->CurrentValue;
		$this->KETERANGAN_STATUS->ViewCustomAttributes = "";

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

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->ViewValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->ViewCustomAttributes = "";

		// biaya_obat
		$this->biaya_obat->ViewValue = $this->biaya_obat->CurrentValue;
		$this->biaya_obat->ViewCustomAttributes = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->ViewValue = $this->biaya_retur_obat->CurrentValue;
		$this->biaya_retur_obat->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL->ViewValue = $this->TOTAL_BIAYA_OBAT_RAJAL->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_RAJAL->ViewCustomAttributes = "";

		// biaya_obat_rajal
		$this->biaya_obat_rajal->ViewValue = $this->biaya_obat_rajal->CurrentValue;
		$this->biaya_obat_rajal->ViewCustomAttributes = "";

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal->ViewValue = $this->biaya_retur_obat_rajal->CurrentValue;
		$this->biaya_retur_obat_rajal->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD->ViewValue = $this->TOTAL_BIAYA_OBAT_IGD->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_IGD->ViewCustomAttributes = "";

		// biaya_obat_igd
		$this->biaya_obat_igd->ViewValue = $this->biaya_obat_igd->CurrentValue;
		$this->biaya_obat_igd->ViewCustomAttributes = "";

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd->ViewValue = $this->biaya_retur_obat_igd->CurrentValue;
		$this->biaya_retur_obat_igd->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS->ViewValue = $this->TOTAL_BIAYA_OBAT_IBS->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_IBS->ViewCustomAttributes = "";

		// biaya_obat_ibs
		$this->biaya_obat_ibs->ViewValue = $this->biaya_obat_ibs->CurrentValue;
		$this->biaya_obat_ibs->ViewCustomAttributes = "";

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs->ViewValue = $this->biaya_retur_obat_ibs->CurrentValue;
		$this->biaya_retur_obat_ibs->ViewCustomAttributes = "";

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
		if (strval($this->MINTA_RUJUKAN->CurrentValue) <> "") {
			$this->MINTA_RUJUKAN->ViewValue = "";
			$arwrk = explode(",", strval($this->MINTA_RUJUKAN->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->MINTA_RUJUKAN->ViewValue .= $this->MINTA_RUJUKAN->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->MINTA_RUJUKAN->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->MINTA_RUJUKAN->ViewValue = NULL;
		}
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

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan->ViewValue = $this->cek_data_kepesertaan->CurrentValue;
		$this->cek_data_kepesertaan->ViewCustomAttributes = "";

		// generate_sep
		$this->generate_sep->ViewValue = $this->generate_sep->CurrentValue;
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

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP->ViewValue = $this->PESERTATGLCETAKKARTU_SEP->CurrentValue;
		$this->PESERTATGLCETAKKARTU_SEP->ViewValue = ew_FormatDateTime($this->PESERTATGLCETAKKARTU_SEP->ViewValue, 0);
		$this->PESERTATGLCETAKKARTU_SEP->ViewCustomAttributes = "";

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

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP->ViewValue = $this->UPDATETGLPLNG_SEP->CurrentValue;
		$this->UPDATETGLPLNG_SEP->ViewValue = ew_FormatDateTime($this->UPDATETGLPLNG_SEP->ViewValue, 0);
		$this->UPDATETGLPLNG_SEP->ViewCustomAttributes = "";

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng->ViewValue = $this->bridging_upt_tglplng->CurrentValue;
		$this->bridging_upt_tglplng->ViewCustomAttributes = "";

		// mapingtransaksi
		$this->mapingtransaksi->ViewValue = $this->mapingtransaksi->CurrentValue;
		$this->mapingtransaksi->ViewCustomAttributes = "";

		// bridging_no_rujukan
		$this->bridging_no_rujukan->ViewValue = $this->bridging_no_rujukan->CurrentValue;
		$this->bridging_no_rujukan->ViewCustomAttributes = "";

		// bridging_hapus_sep
		$this->bridging_hapus_sep->ViewValue = $this->bridging_hapus_sep->CurrentValue;
		$this->bridging_hapus_sep->ViewCustomAttributes = "";

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->ViewValue = $this->bridging_kepesertaan_by_no_ka->CurrentValue;
		$this->bridging_kepesertaan_by_no_ka->ViewCustomAttributes = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->ViewValue = $this->NOKARTU_BPJS->CurrentValue;
		$this->NOKARTU_BPJS->ViewCustomAttributes = "";

		// counter_cetak_kartu
		$this->counter_cetak_kartu->ViewValue = $this->counter_cetak_kartu->CurrentValue;
		$this->counter_cetak_kartu->ViewCustomAttributes = "";

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik->ViewValue = $this->bridging_kepesertaan_by_nik->CurrentValue;
		$this->bridging_kepesertaan_by_nik->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->ViewValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->ViewValue = $this->bridging_by_no_rujukan->CurrentValue;
		$this->bridging_by_no_rujukan->ViewCustomAttributes = "";

		// maping_hapus_sep
		$this->maping_hapus_sep->ViewValue = $this->maping_hapus_sep->CurrentValue;
		$this->maping_hapus_sep->ViewCustomAttributes = "";

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap->ViewValue = $this->counter_cetak_kartu_ranap->CurrentValue;
		$this->counter_cetak_kartu_ranap->ViewCustomAttributes = "";

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN->ViewValue = $this->BIAYA_PENDAFTARAN->CurrentValue;
		$this->BIAYA_PENDAFTARAN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI->ViewValue = $this->BIAYA_TINDAKAN_POLI->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI->ViewValue = $this->BIAYA_TINDAKAN_RADIOLOGI->CurrentValue;
		$this->BIAYA_TINDAKAN_RADIOLOGI->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT->ViewValue = $this->BIAYA_TINDAKAN_LABORAT->CurrentValue;
		$this->BIAYA_TINDAKAN_LABORAT->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI->ViewValue = $this->BIAYA_TINDAKAN_KONSULTASI->CurrentValue;
		$this->BIAYA_TINDAKAN_KONSULTASI->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER->ViewValue = $this->BIAYA_TARIF_DOKTER->CurrentValue;
		$this->BIAYA_TARIF_DOKTER->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL->ViewValue = $this->BIAYA_TARIF_DOKTER_KONSUL->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_KONSUL->ViewCustomAttributes = "";

		// INCLUDE
		$this->INCLUDE->ViewValue = $this->INCLUDE->CurrentValue;
		$this->INCLUDE->ViewCustomAttributes = "";

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal->ViewValue = $this->eklaim_kelas_rawat_rajal->CurrentValue;
		$this->eklaim_kelas_rawat_rajal->ViewCustomAttributes = "";

		// eklaim_adl_score
		$this->eklaim_adl_score->ViewValue = $this->eklaim_adl_score->CurrentValue;
		$this->eklaim_adl_score->ViewCustomAttributes = "";

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute->ViewValue = $this->eklaim_adl_sub_acute->CurrentValue;
		$this->eklaim_adl_sub_acute->ViewCustomAttributes = "";

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic->ViewValue = $this->eklaim_adl_chronic->CurrentValue;
		$this->eklaim_adl_chronic->ViewCustomAttributes = "";

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator->ViewValue = $this->eklaim_icu_indikator->CurrentValue;
		$this->eklaim_icu_indikator->ViewCustomAttributes = "";

		// eklaim_icu_los
		$this->eklaim_icu_los->ViewValue = $this->eklaim_icu_los->CurrentValue;
		$this->eklaim_icu_los->ViewCustomAttributes = "";

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour->ViewValue = $this->eklaim_ventilator_hour->CurrentValue;
		$this->eklaim_ventilator_hour->ViewCustomAttributes = "";

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind->ViewValue = $this->eklaim_upgrade_class_ind->CurrentValue;
		$this->eklaim_upgrade_class_ind->ViewCustomAttributes = "";

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class->ViewValue = $this->eklaim_upgrade_class_class->CurrentValue;
		$this->eklaim_upgrade_class_class->ViewCustomAttributes = "";

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los->ViewValue = $this->eklaim_upgrade_class_los->CurrentValue;
		$this->eklaim_upgrade_class_los->ViewCustomAttributes = "";

		// eklaim_birth_weight
		$this->eklaim_birth_weight->ViewValue = $this->eklaim_birth_weight->CurrentValue;
		$this->eklaim_birth_weight->ViewCustomAttributes = "";

		// eklaim_discharge_status
		$this->eklaim_discharge_status->ViewValue = $this->eklaim_discharge_status->CurrentValue;
		$this->eklaim_discharge_status->ViewCustomAttributes = "";

		// eklaim_diagnosa
		$this->eklaim_diagnosa->ViewValue = $this->eklaim_diagnosa->CurrentValue;
		$this->eklaim_diagnosa->ViewCustomAttributes = "";

		// eklaim_procedure
		$this->eklaim_procedure->ViewValue = $this->eklaim_procedure->CurrentValue;
		$this->eklaim_procedure->ViewCustomAttributes = "";

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs->ViewValue = $this->eklaim_tarif_rs->CurrentValue;
		$this->eklaim_tarif_rs->ViewCustomAttributes = "";

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks->ViewValue = $this->eklaim_tarif_poli_eks->CurrentValue;
		$this->eklaim_tarif_poli_eks->ViewCustomAttributes = "";

		// eklaim_id_dokter
		$this->eklaim_id_dokter->ViewValue = $this->eklaim_id_dokter->CurrentValue;
		$this->eklaim_id_dokter->ViewCustomAttributes = "";

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter->ViewValue = $this->eklaim_nama_dokter->CurrentValue;
		$this->eklaim_nama_dokter->ViewCustomAttributes = "";

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif->ViewValue = $this->eklaim_kode_tarif->CurrentValue;
		$this->eklaim_kode_tarif->ViewCustomAttributes = "";

		// eklaim_payor_id
		$this->eklaim_payor_id->ViewValue = $this->eklaim_payor_id->CurrentValue;
		$this->eklaim_payor_id->ViewCustomAttributes = "";

		// eklaim_payor_cd
		$this->eklaim_payor_cd->ViewValue = $this->eklaim_payor_cd->CurrentValue;
		$this->eklaim_payor_cd->ViewCustomAttributes = "";

		// eklaim_coder_nik
		$this->eklaim_coder_nik->ViewValue = $this->eklaim_coder_nik->CurrentValue;
		$this->eklaim_coder_nik->ViewCustomAttributes = "";

		// eklaim_los
		$this->eklaim_los->ViewValue = $this->eklaim_los->CurrentValue;
		$this->eklaim_los->ViewCustomAttributes = "";

		// eklaim_patient_id
		$this->eklaim_patient_id->ViewValue = $this->eklaim_patient_id->CurrentValue;
		$this->eklaim_patient_id->ViewCustomAttributes = "";

		// eklaim_admission_id
		$this->eklaim_admission_id->ViewValue = $this->eklaim_admission_id->CurrentValue;
		$this->eklaim_admission_id->ViewCustomAttributes = "";

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id->ViewValue = $this->eklaim_hospital_admission_id->CurrentValue;
		$this->eklaim_hospital_admission_id->ViewCustomAttributes = "";

		// bridging_hapussep
		$this->bridging_hapussep->ViewValue = $this->bridging_hapussep->CurrentValue;
		$this->bridging_hapussep->ViewCustomAttributes = "";

		// user_penghapus_sep
		$this->user_penghapus_sep->ViewValue = $this->user_penghapus_sep->CurrentValue;
		$this->user_penghapus_sep->ViewCustomAttributes = "";

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL->ViewValue = $this->BIAYA_BILLING_RAJAL->CurrentValue;
		$this->BIAYA_BILLING_RAJAL->ViewCustomAttributes = "";

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN->ViewValue = $this->STATUS_PEMBAYARAN->CurrentValue;
		$this->STATUS_PEMBAYARAN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI->ViewValue = $this->BIAYA_TINDAKAN_FISIOTERAPI->CurrentValue;
		$this->BIAYA_TINDAKAN_FISIOTERAPI->ViewCustomAttributes = "";

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien->ViewValue = $this->eklaim_reg_pasien->CurrentValue;
		$this->eklaim_reg_pasien->ViewCustomAttributes = "";

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru->ViewValue = $this->eklaim_reg_klaim_baru->CurrentValue;
		$this->eklaim_reg_klaim_baru->ViewCustomAttributes = "";

		// eklaim_gruper1
		$this->eklaim_gruper1->ViewValue = $this->eklaim_gruper1->CurrentValue;
		$this->eklaim_gruper1->ViewCustomAttributes = "";

		// eklaim_gruper2
		$this->eklaim_gruper2->ViewValue = $this->eklaim_gruper2->CurrentValue;
		$this->eklaim_gruper2->ViewCustomAttributes = "";

		// eklaim_finalklaim
		$this->eklaim_finalklaim->ViewValue = $this->eklaim_finalklaim->CurrentValue;
		$this->eklaim_finalklaim->ViewCustomAttributes = "";

		// eklaim_sendklaim
		$this->eklaim_sendklaim->ViewValue = $this->eklaim_sendklaim->CurrentValue;
		$this->eklaim_sendklaim->ViewCustomAttributes = "";

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien->ViewValue = $this->eklaim_flag_hapus_pasien->CurrentValue;
		$this->eklaim_flag_hapus_pasien->ViewCustomAttributes = "";

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim->ViewValue = $this->eklaim_flag_hapus_klaim->CurrentValue;
		$this->eklaim_flag_hapus_klaim->ViewCustomAttributes = "";

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status->ViewValue = $this->eklaim_kemkes_dc_Status->CurrentValue;
		$this->eklaim_kemkes_dc_Status->ViewCustomAttributes = "";

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status->ViewValue = $this->eklaim_bpjs_dc_Status->CurrentValue;
		$this->eklaim_bpjs_dc_Status->ViewCustomAttributes = "";

		// eklaim_cbg_code
		$this->eklaim_cbg_code->ViewValue = $this->eklaim_cbg_code->CurrentValue;
		$this->eklaim_cbg_code->ViewCustomAttributes = "";

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition->ViewValue = $this->eklaim_cbg_descprition->CurrentValue;
		$this->eklaim_cbg_descprition->ViewCustomAttributes = "";

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff->ViewValue = $this->eklaim_cbg_tariff->CurrentValue;
		$this->eklaim_cbg_tariff->ViewCustomAttributes = "";

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code->ViewValue = $this->eklaim_sub_acute_code->CurrentValue;
		$this->eklaim_sub_acute_code->ViewCustomAttributes = "";

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi->ViewValue = $this->eklaim_sub_acute_deskripsi->CurrentValue;
		$this->eklaim_sub_acute_deskripsi->ViewCustomAttributes = "";

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff->ViewValue = $this->eklaim_sub_acute_tariff->CurrentValue;
		$this->eklaim_sub_acute_tariff->ViewCustomAttributes = "";

		// eklaim_chronic_code
		$this->eklaim_chronic_code->ViewValue = $this->eklaim_chronic_code->CurrentValue;
		$this->eklaim_chronic_code->ViewCustomAttributes = "";

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi->ViewValue = $this->eklaim_chronic_deskripsi->CurrentValue;
		$this->eklaim_chronic_deskripsi->ViewCustomAttributes = "";

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff->ViewValue = $this->eklaim_chronic_tariff->CurrentValue;
		$this->eklaim_chronic_tariff->ViewCustomAttributes = "";

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version->ViewValue = $this->eklaim_inacbg_version->CurrentValue;
		$this->eklaim_inacbg_version->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_IBS_RAJAL->ViewCustomAttributes = "";

		// VERIFY_ICD
		$this->VERIFY_ICD->ViewValue = $this->VERIFY_ICD->CurrentValue;
		$this->VERIFY_ICD->ViewCustomAttributes = "";

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->ViewValue = $this->bridging_rujukan_faskes_2->CurrentValue;
		$this->bridging_rujukan_faskes_2->ViewCustomAttributes = "";

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim->ViewValue = $this->eklaim_reedit_claim->CurrentValue;
		$this->eklaim_reedit_claim->ViewCustomAttributes = "";

		// KETERANGAN
		$this->KETERANGAN->ViewValue = $this->KETERANGAN->CurrentValue;
		$this->KETERANGAN->ViewCustomAttributes = "";

		// TGLLAHIR
		$this->TGLLAHIR->ViewValue = $this->TGLLAHIR->CurrentValue;
		$this->TGLLAHIR->ViewValue = ew_FormatDateTime($this->TGLLAHIR->ViewValue, 0);
		$this->TGLLAHIR->ViewCustomAttributes = "";

		// USER_KASIR
		$this->USER_KASIR->ViewValue = $this->USER_KASIR->CurrentValue;
		$this->USER_KASIR->ViewCustomAttributes = "";

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping->ViewValue = $this->eklaim_tgl_gruping->CurrentValue;
		$this->eklaim_tgl_gruping->ViewValue = ew_FormatDateTime($this->eklaim_tgl_gruping->ViewValue, 0);
		$this->eklaim_tgl_gruping->ViewCustomAttributes = "";

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim->ViewValue = $this->eklaim_tgl_finalklaim->CurrentValue;
		$this->eklaim_tgl_finalklaim->ViewValue = ew_FormatDateTime($this->eklaim_tgl_finalklaim->ViewValue, 0);
		$this->eklaim_tgl_finalklaim->ViewCustomAttributes = "";

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim->ViewValue = $this->eklaim_tgl_kirim_klaim->CurrentValue;
		$this->eklaim_tgl_kirim_klaim->ViewValue = ew_FormatDateTime($this->eklaim_tgl_kirim_klaim->ViewValue, 0);
		$this->eklaim_tgl_kirim_klaim->ViewCustomAttributes = "";

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS->ViewValue = $this->BIAYA_OBAT_RS->CurrentValue;
		$this->BIAYA_OBAT_RS->ViewCustomAttributes = "";

		// EKG_RAJAL
		$this->EKG_RAJAL->ViewValue = $this->EKG_RAJAL->CurrentValue;
		$this->EKG_RAJAL->ViewCustomAttributes = "";

		// USG_RAJAL
		$this->USG_RAJAL->ViewValue = $this->USG_RAJAL->CurrentValue;
		$this->USG_RAJAL->ViewCustomAttributes = "";

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL->ViewValue = $this->FISIOTERAPI_RAJAL->CurrentValue;
		$this->FISIOTERAPI_RAJAL->ViewCustomAttributes = "";

		// BHP_RAJAL
		$this->BHP_RAJAL->ViewValue = $this->BHP_RAJAL->CurrentValue;
		$this->BHP_RAJAL->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->ViewCustomAttributes = "";

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL->ViewValue = $this->TOTAL_BIAYA_IBS_RAJAL->CurrentValue;
		$this->TOTAL_BIAYA_IBS_RAJAL->ViewCustomAttributes = "";

		// ORDER_LAB
		$this->ORDER_LAB->ViewValue = $this->ORDER_LAB->CurrentValue;
		$this->ORDER_LAB->ViewCustomAttributes = "";

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI->ViewValue = $this->BILL_RAJAL_SELESAI->CurrentValue;
		$this->BILL_RAJAL_SELESAI->ViewCustomAttributes = "";

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR->ViewValue = $this->INCLUDE_IDXDAFTAR->CurrentValue;
		$this->INCLUDE_IDXDAFTAR->ViewCustomAttributes = "";

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA->ViewValue = $this->INCLUDE_HARGA->CurrentValue;
		$this->INCLUDE_HARGA->ViewCustomAttributes = "";

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA->ViewValue = $this->TARIF_JASA_SARANA->CurrentValue;
		$this->TARIF_JASA_SARANA->ViewCustomAttributes = "";

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS->ViewValue = $this->TARIF_PENUNJANG_NON_MEDIS->CurrentValue;
		$this->TARIF_PENUNJANG_NON_MEDIS->ViewCustomAttributes = "";

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN->ViewValue = $this->TARIF_ASUHAN_KEPERAWATAN->CurrentValue;
		$this->TARIF_ASUHAN_KEPERAWATAN->ViewCustomAttributes = "";

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL->ViewValue = $this->KDDOKTER_RAJAL->CurrentValue;
		$this->KDDOKTER_RAJAL->ViewCustomAttributes = "";

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL->ViewValue = $this->KDDOKTER_KONSUL_RAJAL->CurrentValue;
		$this->KDDOKTER_KONSUL_RAJAL->ViewCustomAttributes = "";

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS->ViewValue = $this->BIAYA_BILLING_RS->CurrentValue;
		$this->BIAYA_BILLING_RS->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO->ViewValue = $this->BIAYA_TINDAKAN_POLI_TMO->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_TMO->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->ViewValue = $this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->ViewCustomAttributes = "";

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO->ViewValue = $this->BHP_RAJAL_TMO->CurrentValue;
		$this->BHP_RAJAL_TMO->ViewCustomAttributes = "";

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN->ViewValue = $this->BHP_RAJAL_KEPERAWATAN->CurrentValue;
		$this->BHP_RAJAL_KEPERAWATAN->ViewCustomAttributes = "";

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI->ViewValue = $this->TARIF_AKOMODASI->CurrentValue;
		$this->TARIF_AKOMODASI->ViewCustomAttributes = "";

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN->ViewValue = $this->TARIF_AMBULAN->CurrentValue;
		$this->TARIF_AMBULAN->ViewCustomAttributes = "";

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN->ViewValue = $this->TARIF_OKSIGEN->CurrentValue;
		$this->TARIF_OKSIGEN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH->ViewValue = $this->BIAYA_TINDAKAN_JENAZAH->CurrentValue;
		$this->BIAYA_TINDAKAN_JENAZAH->ViewCustomAttributes = "";

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD->ViewValue = $this->BIAYA_BILLING_IGD->CurrentValue;
		$this->BIAYA_BILLING_IGD->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->ViewValue = $this->BIAYA_TINDAKAN_POLI_PERSALINAN->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->ViewCustomAttributes = "";

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN->ViewValue = $this->BHP_RAJAL_PERSALINAN->CurrentValue;
		$this->BHP_RAJAL_PERSALINAN->ViewCustomAttributes = "";

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI->ViewValue = $this->TARIF_BIMBINGAN_ROHANI->CurrentValue;
		$this->TARIF_BIMBINGAN_ROHANI->ViewCustomAttributes = "";

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2->ViewValue = $this->BIAYA_BILLING_RS2->CurrentValue;
		$this->BIAYA_BILLING_RS2->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_IGD->ViewCustomAttributes = "";

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD->ViewValue = $this->BIAYA_PENDAFTARAN_IGD->CurrentValue;
		$this->BIAYA_PENDAFTARAN_IGD->ViewCustomAttributes = "";

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS->ViewValue = $this->BIAYA_BILLING_IBS->CurrentValue;
		$this->BIAYA_BILLING_IBS->ViewCustomAttributes = "";

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD->ViewValue = $this->TARIF_JASA_SARANA_IGD->CurrentValue;
		$this->TARIF_JASA_SARANA_IGD->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_KONSUL_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->ViewCustomAttributes = "";

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD->ViewValue = $this->TARIF_MAKAN_IGD->CurrentValue;
		$this->TARIF_MAKAN_IGD->ViewCustomAttributes = "";

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->ViewValue = $this->TARIF_ASUHAN_KEPERAWATAN_IGD->CurrentValue;
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->ViewCustomAttributes = "";

		// pasien_TITLE
		if (strval($this->pasien_TITLE->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_TITLE->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_titel`";
		$sWhereWrk = "";
		$this->pasien_TITLE->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_TITLE, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_TITLE->ViewValue = $this->pasien_TITLE->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_TITLE->ViewValue = $this->pasien_TITLE->CurrentValue;
			}
		} else {
			$this->pasien_TITLE->ViewValue = NULL;
		}
		$this->pasien_TITLE->ViewCustomAttributes = "";

		// pasien_NAMA
		$this->pasien_NAMA->ViewValue = $this->pasien_NAMA->CurrentValue;
		$this->pasien_NAMA->ViewCustomAttributes = "";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->ViewValue = $this->pasien_TEMPAT->CurrentValue;
		$this->pasien_TEMPAT->ViewCustomAttributes = "";

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->ViewValue = $this->pasien_TGLLAHIR->CurrentValue;
		$this->pasien_TGLLAHIR->ViewValue = ew_FormatDateTime($this->pasien_TGLLAHIR->ViewValue, 7);
		$this->pasien_TGLLAHIR->ViewCustomAttributes = "";

		// pasien_JENISKELAMIN
		if (strval($this->pasien_JENISKELAMIN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
		$sWhereWrk = "";
		$this->pasien_JENISKELAMIN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_JENISKELAMIN->ViewValue = $this->pasien_JENISKELAMIN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_JENISKELAMIN->ViewValue = $this->pasien_JENISKELAMIN->CurrentValue;
			}
		} else {
			$this->pasien_JENISKELAMIN->ViewValue = NULL;
		}
		$this->pasien_JENISKELAMIN->ViewCustomAttributes = "";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->ViewValue = $this->pasien_ALAMAT->CurrentValue;
		$this->pasien_ALAMAT->ViewCustomAttributes = "";

		// pasien_KELURAHAN
		$this->pasien_KELURAHAN->ViewValue = $this->pasien_KELURAHAN->CurrentValue;
		$this->pasien_KELURAHAN->ViewCustomAttributes = "";

		// pasien_KDKECAMATAN
		$this->pasien_KDKECAMATAN->ViewValue = $this->pasien_KDKECAMATAN->CurrentValue;
		$this->pasien_KDKECAMATAN->ViewCustomAttributes = "";

		// pasien_KOTA
		$this->pasien_KOTA->ViewValue = $this->pasien_KOTA->CurrentValue;
		$this->pasien_KOTA->ViewCustomAttributes = "";

		// pasien_KDPROVINSI
		$this->pasien_KDPROVINSI->ViewValue = $this->pasien_KDPROVINSI->CurrentValue;
		$this->pasien_KDPROVINSI->ViewCustomAttributes = "";

		// pasien_NOTELP
		$this->pasien_NOTELP->ViewValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->ViewCustomAttributes = "";

		// pasien_NOKTP
		$this->pasien_NOKTP->ViewValue = $this->pasien_NOKTP->CurrentValue;
		$this->pasien_NOKTP->ViewCustomAttributes = "";

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU->ViewValue = $this->pasien_SUAMI_ORTU->CurrentValue;
		$this->pasien_SUAMI_ORTU->ViewCustomAttributes = "";

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->ViewValue = $this->pasien_PEKERJAAN->CurrentValue;
		$this->pasien_PEKERJAAN->ViewCustomAttributes = "";

		// pasien_AGAMA
		if (strval($this->pasien_AGAMA->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_AGAMA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_agama`";
		$sWhereWrk = "";
		$this->pasien_AGAMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_AGAMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_AGAMA->ViewValue = $this->pasien_AGAMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_AGAMA->ViewValue = $this->pasien_AGAMA->CurrentValue;
			}
		} else {
			$this->pasien_AGAMA->ViewValue = NULL;
		}
		$this->pasien_AGAMA->ViewCustomAttributes = "";

		// pasien_PENDIDIKAN
		if (strval($this->pasien_PENDIDIKAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_PENDIDIKAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_pendidikanterakhir`";
		$sWhereWrk = "";
		$this->pasien_PENDIDIKAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_PENDIDIKAN->ViewValue = $this->pasien_PENDIDIKAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_PENDIDIKAN->ViewValue = $this->pasien_PENDIDIKAN->CurrentValue;
			}
		} else {
			$this->pasien_PENDIDIKAN->ViewValue = NULL;
		}
		$this->pasien_PENDIDIKAN->ViewCustomAttributes = "";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->ViewValue = $this->pasien_ALAMAT_KTP->CurrentValue;
		$this->pasien_ALAMAT_KTP->ViewCustomAttributes = "";

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->ViewValue = $this->pasien_NO_KARTU->CurrentValue;
		$this->pasien_NO_KARTU->ViewCustomAttributes = "";

		// pasien_JNS_PASIEN
		if (strval($this->pasien_JNS_PASIEN->CurrentValue) <> "") {
			$sFilterWrk = "`jenis_pasien`" . ew_SearchString("=", $this->pasien_JNS_PASIEN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `jenis_pasien`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_pasien`";
		$sWhereWrk = "";
		$this->pasien_JNS_PASIEN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_JNS_PASIEN->ViewValue = $this->pasien_JNS_PASIEN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_JNS_PASIEN->ViewValue = $this->pasien_JNS_PASIEN->CurrentValue;
			}
		} else {
			$this->pasien_JNS_PASIEN->ViewValue = NULL;
		}
		$this->pasien_JNS_PASIEN->ViewCustomAttributes = "";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->ViewValue = $this->pasien_nama_ayah->CurrentValue;
		$this->pasien_nama_ayah->ViewCustomAttributes = "";

		// pasien_nama_ibu
		$this->pasien_nama_ibu->ViewValue = $this->pasien_nama_ibu->CurrentValue;
		$this->pasien_nama_ibu->ViewCustomAttributes = "";

		// pasien_nama_suami
		$this->pasien_nama_suami->ViewValue = $this->pasien_nama_suami->CurrentValue;
		$this->pasien_nama_suami->ViewCustomAttributes = "";

		// pasien_nama_istri
		$this->pasien_nama_istri->ViewValue = $this->pasien_nama_istri->CurrentValue;
		$this->pasien_nama_istri->ViewCustomAttributes = "";

		// pasien_KD_ETNIS
		if (strval($this->pasien_KD_ETNIS->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_ETNIS->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_etnis`";
		$sWhereWrk = "";
		$this->pasien_KD_ETNIS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KD_ETNIS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KD_ETNIS->ViewValue = $this->pasien_KD_ETNIS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KD_ETNIS->ViewValue = $this->pasien_KD_ETNIS->CurrentValue;
			}
		} else {
			$this->pasien_KD_ETNIS->ViewValue = NULL;
		}
		$this->pasien_KD_ETNIS->ViewCustomAttributes = "";

		// pasien_KD_BHS_HARIAN
		if (strval($this->pasien_KD_BHS_HARIAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_BHS_HARIAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_bahasa_harian`";
		$sWhereWrk = "";
		$this->pasien_KD_BHS_HARIAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KD_BHS_HARIAN->ViewValue = $this->pasien_KD_BHS_HARIAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KD_BHS_HARIAN->ViewValue = $this->pasien_KD_BHS_HARIAN->CurrentValue;
			}
		} else {
			$this->pasien_KD_BHS_HARIAN->ViewValue = NULL;
		}
		$this->pasien_KD_BHS_HARIAN->ViewCustomAttributes = "";

		// BILL_FARMASI_SELESAI
		$this->BILL_FARMASI_SELESAI->ViewValue = $this->BILL_FARMASI_SELESAI->CurrentValue;
		$this->BILL_FARMASI_SELESAI->ViewCustomAttributes = "";

		// TARIF_PELAYANAN_SIMRS
		$this->TARIF_PELAYANAN_SIMRS->ViewValue = $this->TARIF_PELAYANAN_SIMRS->CurrentValue;
		$this->TARIF_PELAYANAN_SIMRS->ViewCustomAttributes = "";

		// USER_ADM
		$this->USER_ADM->ViewValue = $this->USER_ADM->CurrentValue;
		$this->USER_ADM->ViewCustomAttributes = "";

		// TARIF_PENUNJANG_NON_MEDIS_IGD
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->ViewValue = $this->TARIF_PENUNJANG_NON_MEDIS_IGD->CurrentValue;
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->ViewCustomAttributes = "";

		// TARIF_PELAYANAN_DARAH
		$this->TARIF_PELAYANAN_DARAH->ViewValue = $this->TARIF_PELAYANAN_DARAH->CurrentValue;
		$this->TARIF_PELAYANAN_DARAH->ViewCustomAttributes = "";

		// penjamin_kkl_id
		$this->penjamin_kkl_id->ViewValue = $this->penjamin_kkl_id->CurrentValue;
		$this->penjamin_kkl_id->ViewCustomAttributes = "";

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->ViewValue = $this->asalfaskesrujukan_id->CurrentValue;
		$this->asalfaskesrujukan_id->ViewCustomAttributes = "";

		// peserta_cob
		$this->peserta_cob->ViewValue = $this->peserta_cob->CurrentValue;
		$this->peserta_cob->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->ViewValue = $this->status_kepesertaan_BPJS->CurrentValue;
		$this->status_kepesertaan_BPJS->ViewCustomAttributes = "";

		// IDXDAFTAR
		$this->IDXDAFTAR->LinkCustomAttributes = "";
		$this->IDXDAFTAR->HrefValue = "";
		$this->IDXDAFTAR->TooltipValue = "";

		// PASIENBARU
		$this->PASIENBARU->LinkCustomAttributes = "";
		$this->PASIENBARU->HrefValue = "";
		$this->PASIENBARU->TooltipValue = "";

		// NOMR
		$this->NOMR->LinkCustomAttributes = "";
		$this->NOMR->HrefValue = "";
		$this->NOMR->TooltipValue = "";

		// TGLREG
		$this->TGLREG->LinkCustomAttributes = "";
		$this->TGLREG->HrefValue = "";
		$this->TGLREG->TooltipValue = "";

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

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->LinkCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT->HrefValue = "";
		$this->TOTAL_BIAYA_OBAT->TooltipValue = "";

		// biaya_obat
		$this->biaya_obat->LinkCustomAttributes = "";
		$this->biaya_obat->HrefValue = "";
		$this->biaya_obat->TooltipValue = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->LinkCustomAttributes = "";
		$this->biaya_retur_obat->HrefValue = "";
		$this->biaya_retur_obat->TooltipValue = "";

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL->LinkCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT_RAJAL->HrefValue = "";
		$this->TOTAL_BIAYA_OBAT_RAJAL->TooltipValue = "";

		// biaya_obat_rajal
		$this->biaya_obat_rajal->LinkCustomAttributes = "";
		$this->biaya_obat_rajal->HrefValue = "";
		$this->biaya_obat_rajal->TooltipValue = "";

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal->LinkCustomAttributes = "";
		$this->biaya_retur_obat_rajal->HrefValue = "";
		$this->biaya_retur_obat_rajal->TooltipValue = "";

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD->LinkCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT_IGD->HrefValue = "";
		$this->TOTAL_BIAYA_OBAT_IGD->TooltipValue = "";

		// biaya_obat_igd
		$this->biaya_obat_igd->LinkCustomAttributes = "";
		$this->biaya_obat_igd->HrefValue = "";
		$this->biaya_obat_igd->TooltipValue = "";

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd->LinkCustomAttributes = "";
		$this->biaya_retur_obat_igd->HrefValue = "";
		$this->biaya_retur_obat_igd->TooltipValue = "";

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS->LinkCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT_IBS->HrefValue = "";
		$this->TOTAL_BIAYA_OBAT_IBS->TooltipValue = "";

		// biaya_obat_ibs
		$this->biaya_obat_ibs->LinkCustomAttributes = "";
		$this->biaya_obat_ibs->HrefValue = "";
		$this->biaya_obat_ibs->TooltipValue = "";

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs->LinkCustomAttributes = "";
		$this->biaya_retur_obat_ibs->HrefValue = "";
		$this->biaya_retur_obat_ibs->TooltipValue = "";

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

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan->LinkCustomAttributes = "";
		$this->cek_data_kepesertaan->HrefValue = "";
		$this->cek_data_kepesertaan->TooltipValue = "";

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

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP->LinkCustomAttributes = "";
		$this->PESERTATGLCETAKKARTU_SEP->HrefValue = "";
		$this->PESERTATGLCETAKKARTU_SEP->TooltipValue = "";

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

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP->LinkCustomAttributes = "";
		$this->UPDATETGLPLNG_SEP->HrefValue = "";
		$this->UPDATETGLPLNG_SEP->TooltipValue = "";

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng->LinkCustomAttributes = "";
		$this->bridging_upt_tglplng->HrefValue = "";
		$this->bridging_upt_tglplng->TooltipValue = "";

		// mapingtransaksi
		$this->mapingtransaksi->LinkCustomAttributes = "";
		$this->mapingtransaksi->HrefValue = "";
		$this->mapingtransaksi->TooltipValue = "";

		// bridging_no_rujukan
		$this->bridging_no_rujukan->LinkCustomAttributes = "";
		$this->bridging_no_rujukan->HrefValue = "";
		$this->bridging_no_rujukan->TooltipValue = "";

		// bridging_hapus_sep
		$this->bridging_hapus_sep->LinkCustomAttributes = "";
		$this->bridging_hapus_sep->HrefValue = "";
		$this->bridging_hapus_sep->TooltipValue = "";

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->LinkCustomAttributes = "";
		$this->bridging_kepesertaan_by_no_ka->HrefValue = "";
		$this->bridging_kepesertaan_by_no_ka->TooltipValue = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->LinkCustomAttributes = "";
		$this->NOKARTU_BPJS->HrefValue = "";
		$this->NOKARTU_BPJS->TooltipValue = "";

		// counter_cetak_kartu
		$this->counter_cetak_kartu->LinkCustomAttributes = "";
		$this->counter_cetak_kartu->HrefValue = "";
		$this->counter_cetak_kartu->TooltipValue = "";

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik->LinkCustomAttributes = "";
		$this->bridging_kepesertaan_by_nik->HrefValue = "";
		$this->bridging_kepesertaan_by_nik->TooltipValue = "";

		// NOKTP
		$this->NOKTP->LinkCustomAttributes = "";
		$this->NOKTP->HrefValue = "";
		$this->NOKTP->TooltipValue = "";

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->LinkCustomAttributes = "";
		$this->bridging_by_no_rujukan->HrefValue = "";
		$this->bridging_by_no_rujukan->TooltipValue = "";

		// maping_hapus_sep
		$this->maping_hapus_sep->LinkCustomAttributes = "";
		$this->maping_hapus_sep->HrefValue = "";
		$this->maping_hapus_sep->TooltipValue = "";

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap->LinkCustomAttributes = "";
		$this->counter_cetak_kartu_ranap->HrefValue = "";
		$this->counter_cetak_kartu_ranap->TooltipValue = "";

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN->LinkCustomAttributes = "";
		$this->BIAYA_PENDAFTARAN->HrefValue = "";
		$this->BIAYA_PENDAFTARAN->TooltipValue = "";

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_POLI->HrefValue = "";
		$this->BIAYA_TINDAKAN_POLI->TooltipValue = "";

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_RADIOLOGI->HrefValue = "";
		$this->BIAYA_TINDAKAN_RADIOLOGI->TooltipValue = "";

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_LABORAT->HrefValue = "";
		$this->BIAYA_TINDAKAN_LABORAT->TooltipValue = "";

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_KONSULTASI->HrefValue = "";
		$this->BIAYA_TINDAKAN_KONSULTASI->TooltipValue = "";

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER->LinkCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER->HrefValue = "";
		$this->BIAYA_TARIF_DOKTER->TooltipValue = "";

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL->LinkCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER_KONSUL->HrefValue = "";
		$this->BIAYA_TARIF_DOKTER_KONSUL->TooltipValue = "";

		// INCLUDE
		$this->INCLUDE->LinkCustomAttributes = "";
		$this->INCLUDE->HrefValue = "";
		$this->INCLUDE->TooltipValue = "";

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal->LinkCustomAttributes = "";
		$this->eklaim_kelas_rawat_rajal->HrefValue = "";
		$this->eklaim_kelas_rawat_rajal->TooltipValue = "";

		// eklaim_adl_score
		$this->eklaim_adl_score->LinkCustomAttributes = "";
		$this->eklaim_adl_score->HrefValue = "";
		$this->eklaim_adl_score->TooltipValue = "";

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute->LinkCustomAttributes = "";
		$this->eklaim_adl_sub_acute->HrefValue = "";
		$this->eklaim_adl_sub_acute->TooltipValue = "";

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic->LinkCustomAttributes = "";
		$this->eklaim_adl_chronic->HrefValue = "";
		$this->eklaim_adl_chronic->TooltipValue = "";

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator->LinkCustomAttributes = "";
		$this->eklaim_icu_indikator->HrefValue = "";
		$this->eklaim_icu_indikator->TooltipValue = "";

		// eklaim_icu_los
		$this->eklaim_icu_los->LinkCustomAttributes = "";
		$this->eklaim_icu_los->HrefValue = "";
		$this->eklaim_icu_los->TooltipValue = "";

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour->LinkCustomAttributes = "";
		$this->eklaim_ventilator_hour->HrefValue = "";
		$this->eklaim_ventilator_hour->TooltipValue = "";

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind->LinkCustomAttributes = "";
		$this->eklaim_upgrade_class_ind->HrefValue = "";
		$this->eklaim_upgrade_class_ind->TooltipValue = "";

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class->LinkCustomAttributes = "";
		$this->eklaim_upgrade_class_class->HrefValue = "";
		$this->eklaim_upgrade_class_class->TooltipValue = "";

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los->LinkCustomAttributes = "";
		$this->eklaim_upgrade_class_los->HrefValue = "";
		$this->eklaim_upgrade_class_los->TooltipValue = "";

		// eklaim_birth_weight
		$this->eklaim_birth_weight->LinkCustomAttributes = "";
		$this->eklaim_birth_weight->HrefValue = "";
		$this->eklaim_birth_weight->TooltipValue = "";

		// eklaim_discharge_status
		$this->eklaim_discharge_status->LinkCustomAttributes = "";
		$this->eklaim_discharge_status->HrefValue = "";
		$this->eklaim_discharge_status->TooltipValue = "";

		// eklaim_diagnosa
		$this->eklaim_diagnosa->LinkCustomAttributes = "";
		$this->eklaim_diagnosa->HrefValue = "";
		$this->eklaim_diagnosa->TooltipValue = "";

		// eklaim_procedure
		$this->eklaim_procedure->LinkCustomAttributes = "";
		$this->eklaim_procedure->HrefValue = "";
		$this->eklaim_procedure->TooltipValue = "";

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs->LinkCustomAttributes = "";
		$this->eklaim_tarif_rs->HrefValue = "";
		$this->eklaim_tarif_rs->TooltipValue = "";

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks->LinkCustomAttributes = "";
		$this->eklaim_tarif_poli_eks->HrefValue = "";
		$this->eklaim_tarif_poli_eks->TooltipValue = "";

		// eklaim_id_dokter
		$this->eklaim_id_dokter->LinkCustomAttributes = "";
		$this->eklaim_id_dokter->HrefValue = "";
		$this->eklaim_id_dokter->TooltipValue = "";

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter->LinkCustomAttributes = "";
		$this->eklaim_nama_dokter->HrefValue = "";
		$this->eklaim_nama_dokter->TooltipValue = "";

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif->LinkCustomAttributes = "";
		$this->eklaim_kode_tarif->HrefValue = "";
		$this->eklaim_kode_tarif->TooltipValue = "";

		// eklaim_payor_id
		$this->eklaim_payor_id->LinkCustomAttributes = "";
		$this->eklaim_payor_id->HrefValue = "";
		$this->eklaim_payor_id->TooltipValue = "";

		// eklaim_payor_cd
		$this->eklaim_payor_cd->LinkCustomAttributes = "";
		$this->eklaim_payor_cd->HrefValue = "";
		$this->eklaim_payor_cd->TooltipValue = "";

		// eklaim_coder_nik
		$this->eklaim_coder_nik->LinkCustomAttributes = "";
		$this->eklaim_coder_nik->HrefValue = "";
		$this->eklaim_coder_nik->TooltipValue = "";

		// eklaim_los
		$this->eklaim_los->LinkCustomAttributes = "";
		$this->eklaim_los->HrefValue = "";
		$this->eklaim_los->TooltipValue = "";

		// eklaim_patient_id
		$this->eklaim_patient_id->LinkCustomAttributes = "";
		$this->eklaim_patient_id->HrefValue = "";
		$this->eklaim_patient_id->TooltipValue = "";

		// eklaim_admission_id
		$this->eklaim_admission_id->LinkCustomAttributes = "";
		$this->eklaim_admission_id->HrefValue = "";
		$this->eklaim_admission_id->TooltipValue = "";

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id->LinkCustomAttributes = "";
		$this->eklaim_hospital_admission_id->HrefValue = "";
		$this->eklaim_hospital_admission_id->TooltipValue = "";

		// bridging_hapussep
		$this->bridging_hapussep->LinkCustomAttributes = "";
		$this->bridging_hapussep->HrefValue = "";
		$this->bridging_hapussep->TooltipValue = "";

		// user_penghapus_sep
		$this->user_penghapus_sep->LinkCustomAttributes = "";
		$this->user_penghapus_sep->HrefValue = "";
		$this->user_penghapus_sep->TooltipValue = "";

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL->LinkCustomAttributes = "";
		$this->BIAYA_BILLING_RAJAL->HrefValue = "";
		$this->BIAYA_BILLING_RAJAL->TooltipValue = "";

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN->LinkCustomAttributes = "";
		$this->STATUS_PEMBAYARAN->HrefValue = "";
		$this->STATUS_PEMBAYARAN->TooltipValue = "";

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_FISIOTERAPI->HrefValue = "";
		$this->BIAYA_TINDAKAN_FISIOTERAPI->TooltipValue = "";

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien->LinkCustomAttributes = "";
		$this->eklaim_reg_pasien->HrefValue = "";
		$this->eklaim_reg_pasien->TooltipValue = "";

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru->LinkCustomAttributes = "";
		$this->eklaim_reg_klaim_baru->HrefValue = "";
		$this->eklaim_reg_klaim_baru->TooltipValue = "";

		// eklaim_gruper1
		$this->eklaim_gruper1->LinkCustomAttributes = "";
		$this->eklaim_gruper1->HrefValue = "";
		$this->eklaim_gruper1->TooltipValue = "";

		// eklaim_gruper2
		$this->eklaim_gruper2->LinkCustomAttributes = "";
		$this->eklaim_gruper2->HrefValue = "";
		$this->eklaim_gruper2->TooltipValue = "";

		// eklaim_finalklaim
		$this->eklaim_finalklaim->LinkCustomAttributes = "";
		$this->eklaim_finalklaim->HrefValue = "";
		$this->eklaim_finalklaim->TooltipValue = "";

		// eklaim_sendklaim
		$this->eklaim_sendklaim->LinkCustomAttributes = "";
		$this->eklaim_sendklaim->HrefValue = "";
		$this->eklaim_sendklaim->TooltipValue = "";

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien->LinkCustomAttributes = "";
		$this->eklaim_flag_hapus_pasien->HrefValue = "";
		$this->eklaim_flag_hapus_pasien->TooltipValue = "";

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim->LinkCustomAttributes = "";
		$this->eklaim_flag_hapus_klaim->HrefValue = "";
		$this->eklaim_flag_hapus_klaim->TooltipValue = "";

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status->LinkCustomAttributes = "";
		$this->eklaim_kemkes_dc_Status->HrefValue = "";
		$this->eklaim_kemkes_dc_Status->TooltipValue = "";

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status->LinkCustomAttributes = "";
		$this->eklaim_bpjs_dc_Status->HrefValue = "";
		$this->eklaim_bpjs_dc_Status->TooltipValue = "";

		// eklaim_cbg_code
		$this->eklaim_cbg_code->LinkCustomAttributes = "";
		$this->eklaim_cbg_code->HrefValue = "";
		$this->eklaim_cbg_code->TooltipValue = "";

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition->LinkCustomAttributes = "";
		$this->eklaim_cbg_descprition->HrefValue = "";
		$this->eklaim_cbg_descprition->TooltipValue = "";

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff->LinkCustomAttributes = "";
		$this->eklaim_cbg_tariff->HrefValue = "";
		$this->eklaim_cbg_tariff->TooltipValue = "";

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code->LinkCustomAttributes = "";
		$this->eklaim_sub_acute_code->HrefValue = "";
		$this->eklaim_sub_acute_code->TooltipValue = "";

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi->LinkCustomAttributes = "";
		$this->eklaim_sub_acute_deskripsi->HrefValue = "";
		$this->eklaim_sub_acute_deskripsi->TooltipValue = "";

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff->LinkCustomAttributes = "";
		$this->eklaim_sub_acute_tariff->HrefValue = "";
		$this->eklaim_sub_acute_tariff->TooltipValue = "";

		// eklaim_chronic_code
		$this->eklaim_chronic_code->LinkCustomAttributes = "";
		$this->eklaim_chronic_code->HrefValue = "";
		$this->eklaim_chronic_code->TooltipValue = "";

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi->LinkCustomAttributes = "";
		$this->eklaim_chronic_deskripsi->HrefValue = "";
		$this->eklaim_chronic_deskripsi->TooltipValue = "";

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff->LinkCustomAttributes = "";
		$this->eklaim_chronic_tariff->HrefValue = "";
		$this->eklaim_chronic_tariff->TooltipValue = "";

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version->LinkCustomAttributes = "";
		$this->eklaim_inacbg_version->HrefValue = "";
		$this->eklaim_inacbg_version->TooltipValue = "";

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_IBS_RAJAL->HrefValue = "";
		$this->BIAYA_TINDAKAN_IBS_RAJAL->TooltipValue = "";

		// VERIFY_ICD
		$this->VERIFY_ICD->LinkCustomAttributes = "";
		$this->VERIFY_ICD->HrefValue = "";
		$this->VERIFY_ICD->TooltipValue = "";

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->LinkCustomAttributes = "";
		$this->bridging_rujukan_faskes_2->HrefValue = "";
		$this->bridging_rujukan_faskes_2->TooltipValue = "";

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim->LinkCustomAttributes = "";
		$this->eklaim_reedit_claim->HrefValue = "";
		$this->eklaim_reedit_claim->TooltipValue = "";

		// KETERANGAN
		$this->KETERANGAN->LinkCustomAttributes = "";
		$this->KETERANGAN->HrefValue = "";
		$this->KETERANGAN->TooltipValue = "";

		// TGLLAHIR
		$this->TGLLAHIR->LinkCustomAttributes = "";
		$this->TGLLAHIR->HrefValue = "";
		$this->TGLLAHIR->TooltipValue = "";

		// USER_KASIR
		$this->USER_KASIR->LinkCustomAttributes = "";
		$this->USER_KASIR->HrefValue = "";
		$this->USER_KASIR->TooltipValue = "";

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping->LinkCustomAttributes = "";
		$this->eklaim_tgl_gruping->HrefValue = "";
		$this->eklaim_tgl_gruping->TooltipValue = "";

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim->LinkCustomAttributes = "";
		$this->eklaim_tgl_finalklaim->HrefValue = "";
		$this->eklaim_tgl_finalklaim->TooltipValue = "";

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim->LinkCustomAttributes = "";
		$this->eklaim_tgl_kirim_klaim->HrefValue = "";
		$this->eklaim_tgl_kirim_klaim->TooltipValue = "";

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS->LinkCustomAttributes = "";
		$this->BIAYA_OBAT_RS->HrefValue = "";
		$this->BIAYA_OBAT_RS->TooltipValue = "";

		// EKG_RAJAL
		$this->EKG_RAJAL->LinkCustomAttributes = "";
		$this->EKG_RAJAL->HrefValue = "";
		$this->EKG_RAJAL->TooltipValue = "";

		// USG_RAJAL
		$this->USG_RAJAL->LinkCustomAttributes = "";
		$this->USG_RAJAL->HrefValue = "";
		$this->USG_RAJAL->TooltipValue = "";

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL->LinkCustomAttributes = "";
		$this->FISIOTERAPI_RAJAL->HrefValue = "";
		$this->FISIOTERAPI_RAJAL->TooltipValue = "";

		// BHP_RAJAL
		$this->BHP_RAJAL->LinkCustomAttributes = "";
		$this->BHP_RAJAL->HrefValue = "";
		$this->BHP_RAJAL->TooltipValue = "";

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->HrefValue = "";
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->TooltipValue = "";

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->HrefValue = "";
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->TooltipValue = "";

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL->LinkCustomAttributes = "";
		$this->TOTAL_BIAYA_IBS_RAJAL->HrefValue = "";
		$this->TOTAL_BIAYA_IBS_RAJAL->TooltipValue = "";

		// ORDER_LAB
		$this->ORDER_LAB->LinkCustomAttributes = "";
		$this->ORDER_LAB->HrefValue = "";
		$this->ORDER_LAB->TooltipValue = "";

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI->LinkCustomAttributes = "";
		$this->BILL_RAJAL_SELESAI->HrefValue = "";
		$this->BILL_RAJAL_SELESAI->TooltipValue = "";

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR->LinkCustomAttributes = "";
		$this->INCLUDE_IDXDAFTAR->HrefValue = "";
		$this->INCLUDE_IDXDAFTAR->TooltipValue = "";

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA->LinkCustomAttributes = "";
		$this->INCLUDE_HARGA->HrefValue = "";
		$this->INCLUDE_HARGA->TooltipValue = "";

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA->LinkCustomAttributes = "";
		$this->TARIF_JASA_SARANA->HrefValue = "";
		$this->TARIF_JASA_SARANA->TooltipValue = "";

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS->LinkCustomAttributes = "";
		$this->TARIF_PENUNJANG_NON_MEDIS->HrefValue = "";
		$this->TARIF_PENUNJANG_NON_MEDIS->TooltipValue = "";

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN->LinkCustomAttributes = "";
		$this->TARIF_ASUHAN_KEPERAWATAN->HrefValue = "";
		$this->TARIF_ASUHAN_KEPERAWATAN->TooltipValue = "";

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL->LinkCustomAttributes = "";
		$this->KDDOKTER_RAJAL->HrefValue = "";
		$this->KDDOKTER_RAJAL->TooltipValue = "";

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL->LinkCustomAttributes = "";
		$this->KDDOKTER_KONSUL_RAJAL->HrefValue = "";
		$this->KDDOKTER_KONSUL_RAJAL->TooltipValue = "";

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS->LinkCustomAttributes = "";
		$this->BIAYA_BILLING_RS->HrefValue = "";
		$this->BIAYA_BILLING_RS->TooltipValue = "";

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_POLI_TMO->HrefValue = "";
		$this->BIAYA_TINDAKAN_POLI_TMO->TooltipValue = "";

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->HrefValue = "";
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->TooltipValue = "";

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO->LinkCustomAttributes = "";
		$this->BHP_RAJAL_TMO->HrefValue = "";
		$this->BHP_RAJAL_TMO->TooltipValue = "";

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN->LinkCustomAttributes = "";
		$this->BHP_RAJAL_KEPERAWATAN->HrefValue = "";
		$this->BHP_RAJAL_KEPERAWATAN->TooltipValue = "";

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI->LinkCustomAttributes = "";
		$this->TARIF_AKOMODASI->HrefValue = "";
		$this->TARIF_AKOMODASI->TooltipValue = "";

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN->LinkCustomAttributes = "";
		$this->TARIF_AMBULAN->HrefValue = "";
		$this->TARIF_AMBULAN->TooltipValue = "";

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN->LinkCustomAttributes = "";
		$this->TARIF_OKSIGEN->HrefValue = "";
		$this->TARIF_OKSIGEN->TooltipValue = "";

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_JENAZAH->HrefValue = "";
		$this->BIAYA_TINDAKAN_JENAZAH->TooltipValue = "";

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD->LinkCustomAttributes = "";
		$this->BIAYA_BILLING_IGD->HrefValue = "";
		$this->BIAYA_BILLING_IGD->TooltipValue = "";

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->LinkCustomAttributes = "";
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->HrefValue = "";
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->TooltipValue = "";

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN->LinkCustomAttributes = "";
		$this->BHP_RAJAL_PERSALINAN->HrefValue = "";
		$this->BHP_RAJAL_PERSALINAN->TooltipValue = "";

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI->LinkCustomAttributes = "";
		$this->TARIF_BIMBINGAN_ROHANI->HrefValue = "";
		$this->TARIF_BIMBINGAN_ROHANI->TooltipValue = "";

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2->LinkCustomAttributes = "";
		$this->BIAYA_BILLING_RS2->HrefValue = "";
		$this->BIAYA_BILLING_RS2->TooltipValue = "";

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD->LinkCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER_IGD->HrefValue = "";
		$this->BIAYA_TARIF_DOKTER_IGD->TooltipValue = "";

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD->LinkCustomAttributes = "";
		$this->BIAYA_PENDAFTARAN_IGD->HrefValue = "";
		$this->BIAYA_PENDAFTARAN_IGD->TooltipValue = "";

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS->LinkCustomAttributes = "";
		$this->BIAYA_BILLING_IBS->HrefValue = "";
		$this->BIAYA_BILLING_IBS->TooltipValue = "";

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD->LinkCustomAttributes = "";
		$this->TARIF_JASA_SARANA_IGD->HrefValue = "";
		$this->TARIF_JASA_SARANA_IGD->TooltipValue = "";

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->LinkCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->HrefValue = "";
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->TooltipValue = "";

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->LinkCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->HrefValue = "";
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->TooltipValue = "";

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD->LinkCustomAttributes = "";
		$this->TARIF_MAKAN_IGD->HrefValue = "";
		$this->TARIF_MAKAN_IGD->TooltipValue = "";

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->LinkCustomAttributes = "";
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->HrefValue = "";
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->TooltipValue = "";

		// pasien_TITLE
		$this->pasien_TITLE->LinkCustomAttributes = "";
		$this->pasien_TITLE->HrefValue = "";
		$this->pasien_TITLE->TooltipValue = "";

		// pasien_NAMA
		$this->pasien_NAMA->LinkCustomAttributes = "";
		$this->pasien_NAMA->HrefValue = "";
		$this->pasien_NAMA->TooltipValue = "";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->LinkCustomAttributes = "";
		$this->pasien_TEMPAT->HrefValue = "";
		$this->pasien_TEMPAT->TooltipValue = "";

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->LinkCustomAttributes = "";
		$this->pasien_TGLLAHIR->HrefValue = "";
		$this->pasien_TGLLAHIR->TooltipValue = "";

		// pasien_JENISKELAMIN
		$this->pasien_JENISKELAMIN->LinkCustomAttributes = "";
		$this->pasien_JENISKELAMIN->HrefValue = "";
		$this->pasien_JENISKELAMIN->TooltipValue = "";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->LinkCustomAttributes = "";
		$this->pasien_ALAMAT->HrefValue = "";
		$this->pasien_ALAMAT->TooltipValue = "";

		// pasien_KELURAHAN
		$this->pasien_KELURAHAN->LinkCustomAttributes = "";
		$this->pasien_KELURAHAN->HrefValue = "";
		$this->pasien_KELURAHAN->TooltipValue = "";

		// pasien_KDKECAMATAN
		$this->pasien_KDKECAMATAN->LinkCustomAttributes = "";
		$this->pasien_KDKECAMATAN->HrefValue = "";
		$this->pasien_KDKECAMATAN->TooltipValue = "";

		// pasien_KOTA
		$this->pasien_KOTA->LinkCustomAttributes = "";
		$this->pasien_KOTA->HrefValue = "";
		$this->pasien_KOTA->TooltipValue = "";

		// pasien_KDPROVINSI
		$this->pasien_KDPROVINSI->LinkCustomAttributes = "";
		$this->pasien_KDPROVINSI->HrefValue = "";
		$this->pasien_KDPROVINSI->TooltipValue = "";

		// pasien_NOTELP
		$this->pasien_NOTELP->LinkCustomAttributes = "";
		$this->pasien_NOTELP->HrefValue = "";
		$this->pasien_NOTELP->TooltipValue = "";

		// pasien_NOKTP
		$this->pasien_NOKTP->LinkCustomAttributes = "";
		$this->pasien_NOKTP->HrefValue = "";
		$this->pasien_NOKTP->TooltipValue = "";

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU->LinkCustomAttributes = "";
		$this->pasien_SUAMI_ORTU->HrefValue = "";
		$this->pasien_SUAMI_ORTU->TooltipValue = "";

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->LinkCustomAttributes = "";
		$this->pasien_PEKERJAAN->HrefValue = "";
		$this->pasien_PEKERJAAN->TooltipValue = "";

		// pasien_AGAMA
		$this->pasien_AGAMA->LinkCustomAttributes = "";
		$this->pasien_AGAMA->HrefValue = "";
		$this->pasien_AGAMA->TooltipValue = "";

		// pasien_PENDIDIKAN
		$this->pasien_PENDIDIKAN->LinkCustomAttributes = "";
		$this->pasien_PENDIDIKAN->HrefValue = "";
		$this->pasien_PENDIDIKAN->TooltipValue = "";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->LinkCustomAttributes = "";
		$this->pasien_ALAMAT_KTP->HrefValue = "";
		$this->pasien_ALAMAT_KTP->TooltipValue = "";

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->LinkCustomAttributes = "";
		$this->pasien_NO_KARTU->HrefValue = "";
		$this->pasien_NO_KARTU->TooltipValue = "";

		// pasien_JNS_PASIEN
		$this->pasien_JNS_PASIEN->LinkCustomAttributes = "";
		$this->pasien_JNS_PASIEN->HrefValue = "";
		$this->pasien_JNS_PASIEN->TooltipValue = "";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->LinkCustomAttributes = "";
		$this->pasien_nama_ayah->HrefValue = "";
		$this->pasien_nama_ayah->TooltipValue = "";

		// pasien_nama_ibu
		$this->pasien_nama_ibu->LinkCustomAttributes = "";
		$this->pasien_nama_ibu->HrefValue = "";
		$this->pasien_nama_ibu->TooltipValue = "";

		// pasien_nama_suami
		$this->pasien_nama_suami->LinkCustomAttributes = "";
		$this->pasien_nama_suami->HrefValue = "";
		$this->pasien_nama_suami->TooltipValue = "";

		// pasien_nama_istri
		$this->pasien_nama_istri->LinkCustomAttributes = "";
		$this->pasien_nama_istri->HrefValue = "";
		$this->pasien_nama_istri->TooltipValue = "";

		// pasien_KD_ETNIS
		$this->pasien_KD_ETNIS->LinkCustomAttributes = "";
		$this->pasien_KD_ETNIS->HrefValue = "";
		$this->pasien_KD_ETNIS->TooltipValue = "";

		// pasien_KD_BHS_HARIAN
		$this->pasien_KD_BHS_HARIAN->LinkCustomAttributes = "";
		$this->pasien_KD_BHS_HARIAN->HrefValue = "";
		$this->pasien_KD_BHS_HARIAN->TooltipValue = "";

		// BILL_FARMASI_SELESAI
		$this->BILL_FARMASI_SELESAI->LinkCustomAttributes = "";
		$this->BILL_FARMASI_SELESAI->HrefValue = "";
		$this->BILL_FARMASI_SELESAI->TooltipValue = "";

		// TARIF_PELAYANAN_SIMRS
		$this->TARIF_PELAYANAN_SIMRS->LinkCustomAttributes = "";
		$this->TARIF_PELAYANAN_SIMRS->HrefValue = "";
		$this->TARIF_PELAYANAN_SIMRS->TooltipValue = "";

		// USER_ADM
		$this->USER_ADM->LinkCustomAttributes = "";
		$this->USER_ADM->HrefValue = "";
		$this->USER_ADM->TooltipValue = "";

		// TARIF_PENUNJANG_NON_MEDIS_IGD
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->LinkCustomAttributes = "";
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->HrefValue = "";
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->TooltipValue = "";

		// TARIF_PELAYANAN_DARAH
		$this->TARIF_PELAYANAN_DARAH->LinkCustomAttributes = "";
		$this->TARIF_PELAYANAN_DARAH->HrefValue = "";
		$this->TARIF_PELAYANAN_DARAH->TooltipValue = "";

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

		// PASIENBARU
		$this->PASIENBARU->EditAttrs["class"] = "form-control";
		$this->PASIENBARU->EditCustomAttributes = "";
		$this->PASIENBARU->EditValue = $this->PASIENBARU->Options(TRUE);

		// NOMR
		$this->NOMR->EditAttrs["class"] = "form-control";
		$this->NOMR->EditCustomAttributes = "";
		$this->NOMR->EditValue = $this->NOMR->CurrentValue;
		$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

		// TGLREG
		$this->TGLREG->EditAttrs["class"] = "form-control";
		$this->TGLREG->EditCustomAttributes = "";
		$this->TGLREG->EditValue = ew_FormatDateTime($this->TGLREG->CurrentValue, 7);
		$this->TGLREG->PlaceHolder = ew_RemoveHtml($this->TGLREG->FldCaption());

		// KDDOKTER
		$this->KDDOKTER->EditAttrs["class"] = "form-control";
		$this->KDDOKTER->EditCustomAttributes = "";

		// KDPOLY
		$this->KDPOLY->EditAttrs["class"] = "form-control";
		$this->KDPOLY->EditCustomAttributes = "";

		// KDRUJUK
		$this->KDRUJUK->EditAttrs["class"] = "form-control";
		$this->KDRUJUK->EditCustomAttributes = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->EditAttrs["class"] = "form-control";
		$this->KDCARABAYAR->EditCustomAttributes = "";

		// NOJAMINAN
		$this->NOJAMINAN->EditAttrs["class"] = "form-control";
		$this->NOJAMINAN->EditCustomAttributes = "";
		$this->NOJAMINAN->EditValue = $this->NOJAMINAN->CurrentValue;
		$this->NOJAMINAN->PlaceHolder = ew_RemoveHtml($this->NOJAMINAN->FldCaption());

		// SHIFT
		$this->SHIFT->EditCustomAttributes = "";

		// STATUS
		$this->STATUS->EditAttrs["class"] = "form-control";
		$this->STATUS->EditCustomAttributes = "";
		$this->STATUS->EditValue = $this->STATUS->CurrentValue;
		$this->STATUS->PlaceHolder = ew_RemoveHtml($this->STATUS->FldCaption());

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->EditAttrs["class"] = "form-control";
		$this->KETERANGAN_STATUS->EditCustomAttributes = "";
		$this->KETERANGAN_STATUS->EditValue = $this->KETERANGAN_STATUS->CurrentValue;
		$this->KETERANGAN_STATUS->PlaceHolder = ew_RemoveHtml($this->KETERANGAN_STATUS->FldCaption());

		// NIP
		$this->NIP->EditAttrs["class"] = "form-control";
		$this->NIP->EditCustomAttributes = "";
		$this->NIP->EditValue = $this->NIP->CurrentValue;
		$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

		// MASUKPOLY
		$this->MASUKPOLY->EditAttrs["class"] = "form-control";
		$this->MASUKPOLY->EditCustomAttributes = "";
		$this->MASUKPOLY->EditValue = $this->MASUKPOLY->CurrentValue;
		$this->MASUKPOLY->PlaceHolder = ew_RemoveHtml($this->MASUKPOLY->FldCaption());

		// KELUARPOLY
		$this->KELUARPOLY->EditAttrs["class"] = "form-control";
		$this->KELUARPOLY->EditCustomAttributes = "";
		$this->KELUARPOLY->EditValue = $this->KELUARPOLY->CurrentValue;
		$this->KELUARPOLY->PlaceHolder = ew_RemoveHtml($this->KELUARPOLY->FldCaption());

		// KETRUJUK
		$this->KETRUJUK->EditAttrs["class"] = "form-control";
		$this->KETRUJUK->EditCustomAttributes = "";
		$this->KETRUJUK->EditValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->PlaceHolder = ew_RemoveHtml($this->KETRUJUK->FldCaption());

		// KETBAYAR
		$this->KETBAYAR->EditAttrs["class"] = "form-control";
		$this->KETBAYAR->EditCustomAttributes = "";
		$this->KETBAYAR->EditValue = $this->KETBAYAR->CurrentValue;
		$this->KETBAYAR->PlaceHolder = ew_RemoveHtml($this->KETBAYAR->FldCaption());

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

		// JAMREG
		$this->JAMREG->EditAttrs["class"] = "form-control";
		$this->JAMREG->EditCustomAttributes = "";
		$this->JAMREG->EditValue = ew_FormatDateTime($this->JAMREG->CurrentValue, 8);
		$this->JAMREG->PlaceHolder = ew_RemoveHtml($this->JAMREG->FldCaption());

		// BATAL
		$this->BATAL->EditAttrs["class"] = "form-control";
		$this->BATAL->EditCustomAttributes = "";
		$this->BATAL->EditValue = $this->BATAL->CurrentValue;
		$this->BATAL->PlaceHolder = ew_RemoveHtml($this->BATAL->FldCaption());

		// NO_SJP
		$this->NO_SJP->EditAttrs["class"] = "form-control";
		$this->NO_SJP->EditCustomAttributes = "";
		$this->NO_SJP->EditValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->PlaceHolder = ew_RemoveHtml($this->NO_SJP->FldCaption());

		// NO_PESERTA
		$this->NO_PESERTA->EditAttrs["class"] = "form-control";
		$this->NO_PESERTA->EditCustomAttributes = "";
		$this->NO_PESERTA->EditValue = $this->NO_PESERTA->CurrentValue;
		$this->NO_PESERTA->PlaceHolder = ew_RemoveHtml($this->NO_PESERTA->FldCaption());

		// NOKARTU
		$this->NOKARTU->EditAttrs["class"] = "form-control";
		$this->NOKARTU->EditCustomAttributes = "";
		$this->NOKARTU->EditValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->PlaceHolder = ew_RemoveHtml($this->NOKARTU->FldCaption());

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->EditAttrs["class"] = "form-control";
		$this->TOTAL_BIAYA_OBAT->EditCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT->EditValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_OBAT->FldCaption());
		if (strval($this->TOTAL_BIAYA_OBAT->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_OBAT->EditValue)) $this->TOTAL_BIAYA_OBAT->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_OBAT->EditValue, -2, -1, -2, 0);

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

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL->EditAttrs["class"] = "form-control";
		$this->TOTAL_BIAYA_OBAT_RAJAL->EditCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT_RAJAL->EditValue = $this->TOTAL_BIAYA_OBAT_RAJAL->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_RAJAL->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_OBAT_RAJAL->FldCaption());
		if (strval($this->TOTAL_BIAYA_OBAT_RAJAL->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_OBAT_RAJAL->EditValue)) $this->TOTAL_BIAYA_OBAT_RAJAL->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_OBAT_RAJAL->EditValue, -2, -1, -2, 0);

		// biaya_obat_rajal
		$this->biaya_obat_rajal->EditAttrs["class"] = "form-control";
		$this->biaya_obat_rajal->EditCustomAttributes = "";
		$this->biaya_obat_rajal->EditValue = $this->biaya_obat_rajal->CurrentValue;
		$this->biaya_obat_rajal->PlaceHolder = ew_RemoveHtml($this->biaya_obat_rajal->FldCaption());
		if (strval($this->biaya_obat_rajal->EditValue) <> "" && is_numeric($this->biaya_obat_rajal->EditValue)) $this->biaya_obat_rajal->EditValue = ew_FormatNumber($this->biaya_obat_rajal->EditValue, -2, -1, -2, 0);

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal->EditAttrs["class"] = "form-control";
		$this->biaya_retur_obat_rajal->EditCustomAttributes = "";
		$this->biaya_retur_obat_rajal->EditValue = $this->biaya_retur_obat_rajal->CurrentValue;
		$this->biaya_retur_obat_rajal->PlaceHolder = ew_RemoveHtml($this->biaya_retur_obat_rajal->FldCaption());
		if (strval($this->biaya_retur_obat_rajal->EditValue) <> "" && is_numeric($this->biaya_retur_obat_rajal->EditValue)) $this->biaya_retur_obat_rajal->EditValue = ew_FormatNumber($this->biaya_retur_obat_rajal->EditValue, -2, -1, -2, 0);

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD->EditAttrs["class"] = "form-control";
		$this->TOTAL_BIAYA_OBAT_IGD->EditCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT_IGD->EditValue = $this->TOTAL_BIAYA_OBAT_IGD->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_IGD->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_OBAT_IGD->FldCaption());
		if (strval($this->TOTAL_BIAYA_OBAT_IGD->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_OBAT_IGD->EditValue)) $this->TOTAL_BIAYA_OBAT_IGD->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_OBAT_IGD->EditValue, -2, -1, -2, 0);

		// biaya_obat_igd
		$this->biaya_obat_igd->EditAttrs["class"] = "form-control";
		$this->biaya_obat_igd->EditCustomAttributes = "";
		$this->biaya_obat_igd->EditValue = $this->biaya_obat_igd->CurrentValue;
		$this->biaya_obat_igd->PlaceHolder = ew_RemoveHtml($this->biaya_obat_igd->FldCaption());
		if (strval($this->biaya_obat_igd->EditValue) <> "" && is_numeric($this->biaya_obat_igd->EditValue)) $this->biaya_obat_igd->EditValue = ew_FormatNumber($this->biaya_obat_igd->EditValue, -2, -1, -2, 0);

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd->EditAttrs["class"] = "form-control";
		$this->biaya_retur_obat_igd->EditCustomAttributes = "";
		$this->biaya_retur_obat_igd->EditValue = $this->biaya_retur_obat_igd->CurrentValue;
		$this->biaya_retur_obat_igd->PlaceHolder = ew_RemoveHtml($this->biaya_retur_obat_igd->FldCaption());
		if (strval($this->biaya_retur_obat_igd->EditValue) <> "" && is_numeric($this->biaya_retur_obat_igd->EditValue)) $this->biaya_retur_obat_igd->EditValue = ew_FormatNumber($this->biaya_retur_obat_igd->EditValue, -2, -1, -2, 0);

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS->EditAttrs["class"] = "form-control";
		$this->TOTAL_BIAYA_OBAT_IBS->EditCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT_IBS->EditValue = $this->TOTAL_BIAYA_OBAT_IBS->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_IBS->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_OBAT_IBS->FldCaption());
		if (strval($this->TOTAL_BIAYA_OBAT_IBS->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_OBAT_IBS->EditValue)) $this->TOTAL_BIAYA_OBAT_IBS->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_OBAT_IBS->EditValue, -2, -1, -2, 0);

		// biaya_obat_ibs
		$this->biaya_obat_ibs->EditAttrs["class"] = "form-control";
		$this->biaya_obat_ibs->EditCustomAttributes = "";
		$this->biaya_obat_ibs->EditValue = $this->biaya_obat_ibs->CurrentValue;
		$this->biaya_obat_ibs->PlaceHolder = ew_RemoveHtml($this->biaya_obat_ibs->FldCaption());
		if (strval($this->biaya_obat_ibs->EditValue) <> "" && is_numeric($this->biaya_obat_ibs->EditValue)) $this->biaya_obat_ibs->EditValue = ew_FormatNumber($this->biaya_obat_ibs->EditValue, -2, -1, -2, 0);

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs->EditAttrs["class"] = "form-control";
		$this->biaya_retur_obat_ibs->EditCustomAttributes = "";
		$this->biaya_retur_obat_ibs->EditValue = $this->biaya_retur_obat_ibs->CurrentValue;
		$this->biaya_retur_obat_ibs->PlaceHolder = ew_RemoveHtml($this->biaya_retur_obat_ibs->FldCaption());
		if (strval($this->biaya_retur_obat_ibs->EditValue) <> "" && is_numeric($this->biaya_retur_obat_ibs->EditValue)) $this->biaya_retur_obat_ibs->EditValue = ew_FormatNumber($this->biaya_retur_obat_ibs->EditValue, -2, -1, -2, 0);

		// TANGGAL_SEP
		$this->TANGGAL_SEP->EditAttrs["class"] = "form-control";
		$this->TANGGAL_SEP->EditCustomAttributes = "";
		$this->TANGGAL_SEP->EditValue = ew_FormatDateTime($this->TANGGAL_SEP->CurrentValue, 8);
		$this->TANGGAL_SEP->PlaceHolder = ew_RemoveHtml($this->TANGGAL_SEP->FldCaption());

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->EditAttrs["class"] = "form-control";
		$this->TANGGALRUJUK_SEP->EditCustomAttributes = "";
		$this->TANGGALRUJUK_SEP->EditValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->CurrentValue, 8);
		$this->TANGGALRUJUK_SEP->PlaceHolder = ew_RemoveHtml($this->TANGGALRUJUK_SEP->FldCaption());

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->EditAttrs["class"] = "form-control";
		$this->KELASRAWAT_SEP->EditCustomAttributes = "";
		$this->KELASRAWAT_SEP->EditValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->PlaceHolder = ew_RemoveHtml($this->KELASRAWAT_SEP->FldCaption());

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->EditCustomAttributes = "";
		$this->MINTA_RUJUKAN->EditValue = $this->MINTA_RUJUKAN->Options(FALSE);

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->EditAttrs["class"] = "form-control";
		$this->NORUJUKAN_SEP->EditCustomAttributes = "";
		$this->NORUJUKAN_SEP->EditValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->PlaceHolder = ew_RemoveHtml($this->NORUJUKAN_SEP->FldCaption());

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->EditAttrs["class"] = "form-control";
		$this->PPKRUJUKANASAL_SEP->EditCustomAttributes = "";
		$this->PPKRUJUKANASAL_SEP->EditValue = $this->PPKRUJUKANASAL_SEP->CurrentValue;
		$this->PPKRUJUKANASAL_SEP->PlaceHolder = ew_RemoveHtml($this->PPKRUJUKANASAL_SEP->FldCaption());

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->EditAttrs["class"] = "form-control";
		$this->NAMAPPKRUJUKANASAL_SEP->EditCustomAttributes = "";
		$this->NAMAPPKRUJUKANASAL_SEP->EditValue = $this->NAMAPPKRUJUKANASAL_SEP->CurrentValue;
		$this->NAMAPPKRUJUKANASAL_SEP->PlaceHolder = ew_RemoveHtml($this->NAMAPPKRUJUKANASAL_SEP->FldCaption());

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->EditAttrs["class"] = "form-control";
		$this->PPKPELAYANAN_SEP->EditCustomAttributes = "";
		$this->PPKPELAYANAN_SEP->EditValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->PlaceHolder = ew_RemoveHtml($this->PPKPELAYANAN_SEP->FldCaption());

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->EditAttrs["class"] = "form-control";
		$this->JENISPERAWATAN_SEP->EditCustomAttributes = "";
		$this->JENISPERAWATAN_SEP->EditValue = $this->JENISPERAWATAN_SEP->CurrentValue;
		$this->JENISPERAWATAN_SEP->PlaceHolder = ew_RemoveHtml($this->JENISPERAWATAN_SEP->FldCaption());

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
		$this->LAKALANTAS_SEP->EditAttrs["class"] = "form-control";
		$this->LAKALANTAS_SEP->EditCustomAttributes = "";
		$this->LAKALANTAS_SEP->EditValue = $this->LAKALANTAS_SEP->CurrentValue;
		$this->LAKALANTAS_SEP->PlaceHolder = ew_RemoveHtml($this->LAKALANTAS_SEP->FldCaption());

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

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan->EditAttrs["class"] = "form-control";
		$this->cek_data_kepesertaan->EditCustomAttributes = "";
		$this->cek_data_kepesertaan->EditValue = $this->cek_data_kepesertaan->CurrentValue;
		$this->cek_data_kepesertaan->PlaceHolder = ew_RemoveHtml($this->cek_data_kepesertaan->FldCaption());

		// generate_sep
		$this->generate_sep->EditAttrs["class"] = "form-control";
		$this->generate_sep->EditCustomAttributes = "";
		$this->generate_sep->EditValue = $this->generate_sep->CurrentValue;
		$this->generate_sep->PlaceHolder = ew_RemoveHtml($this->generate_sep->FldCaption());

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

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP->EditAttrs["class"] = "form-control";
		$this->PESERTATGLCETAKKARTU_SEP->EditCustomAttributes = "";
		$this->PESERTATGLCETAKKARTU_SEP->EditValue = ew_FormatDateTime($this->PESERTATGLCETAKKARTU_SEP->CurrentValue, 8);
		$this->PESERTATGLCETAKKARTU_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTATGLCETAKKARTU_SEP->FldCaption());

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

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP->EditAttrs["class"] = "form-control";
		$this->UPDATETGLPLNG_SEP->EditCustomAttributes = "";
		$this->UPDATETGLPLNG_SEP->EditValue = ew_FormatDateTime($this->UPDATETGLPLNG_SEP->CurrentValue, 8);
		$this->UPDATETGLPLNG_SEP->PlaceHolder = ew_RemoveHtml($this->UPDATETGLPLNG_SEP->FldCaption());

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng->EditAttrs["class"] = "form-control";
		$this->bridging_upt_tglplng->EditCustomAttributes = "";
		$this->bridging_upt_tglplng->EditValue = $this->bridging_upt_tglplng->CurrentValue;
		$this->bridging_upt_tglplng->PlaceHolder = ew_RemoveHtml($this->bridging_upt_tglplng->FldCaption());

		// mapingtransaksi
		$this->mapingtransaksi->EditAttrs["class"] = "form-control";
		$this->mapingtransaksi->EditCustomAttributes = "";
		$this->mapingtransaksi->EditValue = $this->mapingtransaksi->CurrentValue;
		$this->mapingtransaksi->PlaceHolder = ew_RemoveHtml($this->mapingtransaksi->FldCaption());

		// bridging_no_rujukan
		$this->bridging_no_rujukan->EditAttrs["class"] = "form-control";
		$this->bridging_no_rujukan->EditCustomAttributes = "";
		$this->bridging_no_rujukan->EditValue = $this->bridging_no_rujukan->CurrentValue;
		$this->bridging_no_rujukan->PlaceHolder = ew_RemoveHtml($this->bridging_no_rujukan->FldCaption());

		// bridging_hapus_sep
		$this->bridging_hapus_sep->EditAttrs["class"] = "form-control";
		$this->bridging_hapus_sep->EditCustomAttributes = "";
		$this->bridging_hapus_sep->EditValue = $this->bridging_hapus_sep->CurrentValue;
		$this->bridging_hapus_sep->PlaceHolder = ew_RemoveHtml($this->bridging_hapus_sep->FldCaption());

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->EditAttrs["class"] = "form-control";
		$this->bridging_kepesertaan_by_no_ka->EditCustomAttributes = "";
		$this->bridging_kepesertaan_by_no_ka->EditValue = $this->bridging_kepesertaan_by_no_ka->CurrentValue;
		$this->bridging_kepesertaan_by_no_ka->PlaceHolder = ew_RemoveHtml($this->bridging_kepesertaan_by_no_ka->FldCaption());

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->EditAttrs["class"] = "form-control";
		$this->NOKARTU_BPJS->EditCustomAttributes = "";
		$this->NOKARTU_BPJS->EditValue = $this->NOKARTU_BPJS->CurrentValue;
		$this->NOKARTU_BPJS->PlaceHolder = ew_RemoveHtml($this->NOKARTU_BPJS->FldCaption());

		// counter_cetak_kartu
		$this->counter_cetak_kartu->EditAttrs["class"] = "form-control";
		$this->counter_cetak_kartu->EditCustomAttributes = "";
		$this->counter_cetak_kartu->EditValue = $this->counter_cetak_kartu->CurrentValue;
		$this->counter_cetak_kartu->PlaceHolder = ew_RemoveHtml($this->counter_cetak_kartu->FldCaption());

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik->EditAttrs["class"] = "form-control";
		$this->bridging_kepesertaan_by_nik->EditCustomAttributes = "";
		$this->bridging_kepesertaan_by_nik->EditValue = $this->bridging_kepesertaan_by_nik->CurrentValue;
		$this->bridging_kepesertaan_by_nik->PlaceHolder = ew_RemoveHtml($this->bridging_kepesertaan_by_nik->FldCaption());

		// NOKTP
		$this->NOKTP->EditAttrs["class"] = "form-control";
		$this->NOKTP->EditCustomAttributes = "";
		$this->NOKTP->EditValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->PlaceHolder = ew_RemoveHtml($this->NOKTP->FldCaption());

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->EditAttrs["class"] = "form-control";
		$this->bridging_by_no_rujukan->EditCustomAttributes = "";
		$this->bridging_by_no_rujukan->EditValue = $this->bridging_by_no_rujukan->CurrentValue;
		$this->bridging_by_no_rujukan->PlaceHolder = ew_RemoveHtml($this->bridging_by_no_rujukan->FldCaption());

		// maping_hapus_sep
		$this->maping_hapus_sep->EditAttrs["class"] = "form-control";
		$this->maping_hapus_sep->EditCustomAttributes = "";
		$this->maping_hapus_sep->EditValue = $this->maping_hapus_sep->CurrentValue;
		$this->maping_hapus_sep->PlaceHolder = ew_RemoveHtml($this->maping_hapus_sep->FldCaption());

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap->EditAttrs["class"] = "form-control";
		$this->counter_cetak_kartu_ranap->EditCustomAttributes = "";
		$this->counter_cetak_kartu_ranap->EditValue = $this->counter_cetak_kartu_ranap->CurrentValue;
		$this->counter_cetak_kartu_ranap->PlaceHolder = ew_RemoveHtml($this->counter_cetak_kartu_ranap->FldCaption());

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN->EditAttrs["class"] = "form-control";
		$this->BIAYA_PENDAFTARAN->EditCustomAttributes = "";
		$this->BIAYA_PENDAFTARAN->EditValue = $this->BIAYA_PENDAFTARAN->CurrentValue;
		$this->BIAYA_PENDAFTARAN->PlaceHolder = ew_RemoveHtml($this->BIAYA_PENDAFTARAN->FldCaption());
		if (strval($this->BIAYA_PENDAFTARAN->EditValue) <> "" && is_numeric($this->BIAYA_PENDAFTARAN->EditValue)) $this->BIAYA_PENDAFTARAN->EditValue = ew_FormatNumber($this->BIAYA_PENDAFTARAN->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_POLI->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_POLI->EditValue = $this->BIAYA_TINDAKAN_POLI->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_POLI->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_POLI->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_POLI->EditValue)) $this->BIAYA_TINDAKAN_POLI->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_POLI->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_RADIOLOGI->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_RADIOLOGI->EditValue = $this->BIAYA_TINDAKAN_RADIOLOGI->CurrentValue;
		$this->BIAYA_TINDAKAN_RADIOLOGI->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_RADIOLOGI->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_RADIOLOGI->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_RADIOLOGI->EditValue)) $this->BIAYA_TINDAKAN_RADIOLOGI->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_RADIOLOGI->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_LABORAT->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_LABORAT->EditValue = $this->BIAYA_TINDAKAN_LABORAT->CurrentValue;
		$this->BIAYA_TINDAKAN_LABORAT->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_LABORAT->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_LABORAT->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_LABORAT->EditValue)) $this->BIAYA_TINDAKAN_LABORAT->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_LABORAT->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_KONSULTASI->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_KONSULTASI->EditValue = $this->BIAYA_TINDAKAN_KONSULTASI->CurrentValue;
		$this->BIAYA_TINDAKAN_KONSULTASI->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_KONSULTASI->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_KONSULTASI->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_KONSULTASI->EditValue)) $this->BIAYA_TINDAKAN_KONSULTASI->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_KONSULTASI->EditValue, -2, -1, -2, 0);

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER->EditAttrs["class"] = "form-control";
		$this->BIAYA_TARIF_DOKTER->EditCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER->EditValue = $this->BIAYA_TARIF_DOKTER->CurrentValue;
		$this->BIAYA_TARIF_DOKTER->PlaceHolder = ew_RemoveHtml($this->BIAYA_TARIF_DOKTER->FldCaption());
		if (strval($this->BIAYA_TARIF_DOKTER->EditValue) <> "" && is_numeric($this->BIAYA_TARIF_DOKTER->EditValue)) $this->BIAYA_TARIF_DOKTER->EditValue = ew_FormatNumber($this->BIAYA_TARIF_DOKTER->EditValue, -2, -1, -2, 0);

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL->EditAttrs["class"] = "form-control";
		$this->BIAYA_TARIF_DOKTER_KONSUL->EditCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER_KONSUL->EditValue = $this->BIAYA_TARIF_DOKTER_KONSUL->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_KONSUL->PlaceHolder = ew_RemoveHtml($this->BIAYA_TARIF_DOKTER_KONSUL->FldCaption());
		if (strval($this->BIAYA_TARIF_DOKTER_KONSUL->EditValue) <> "" && is_numeric($this->BIAYA_TARIF_DOKTER_KONSUL->EditValue)) $this->BIAYA_TARIF_DOKTER_KONSUL->EditValue = ew_FormatNumber($this->BIAYA_TARIF_DOKTER_KONSUL->EditValue, -2, -1, -2, 0);

		// INCLUDE
		$this->INCLUDE->EditAttrs["class"] = "form-control";
		$this->INCLUDE->EditCustomAttributes = "";
		$this->INCLUDE->EditValue = $this->INCLUDE->CurrentValue;
		$this->INCLUDE->PlaceHolder = ew_RemoveHtml($this->INCLUDE->FldCaption());

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal->EditAttrs["class"] = "form-control";
		$this->eklaim_kelas_rawat_rajal->EditCustomAttributes = "";
		$this->eklaim_kelas_rawat_rajal->EditValue = $this->eklaim_kelas_rawat_rajal->CurrentValue;
		$this->eklaim_kelas_rawat_rajal->PlaceHolder = ew_RemoveHtml($this->eklaim_kelas_rawat_rajal->FldCaption());

		// eklaim_adl_score
		$this->eklaim_adl_score->EditAttrs["class"] = "form-control";
		$this->eklaim_adl_score->EditCustomAttributes = "";
		$this->eklaim_adl_score->EditValue = $this->eklaim_adl_score->CurrentValue;
		$this->eklaim_adl_score->PlaceHolder = ew_RemoveHtml($this->eklaim_adl_score->FldCaption());

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute->EditAttrs["class"] = "form-control";
		$this->eklaim_adl_sub_acute->EditCustomAttributes = "";
		$this->eklaim_adl_sub_acute->EditValue = $this->eklaim_adl_sub_acute->CurrentValue;
		$this->eklaim_adl_sub_acute->PlaceHolder = ew_RemoveHtml($this->eklaim_adl_sub_acute->FldCaption());

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic->EditAttrs["class"] = "form-control";
		$this->eklaim_adl_chronic->EditCustomAttributes = "";
		$this->eklaim_adl_chronic->EditValue = $this->eklaim_adl_chronic->CurrentValue;
		$this->eklaim_adl_chronic->PlaceHolder = ew_RemoveHtml($this->eklaim_adl_chronic->FldCaption());

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator->EditAttrs["class"] = "form-control";
		$this->eklaim_icu_indikator->EditCustomAttributes = "";
		$this->eklaim_icu_indikator->EditValue = $this->eklaim_icu_indikator->CurrentValue;
		$this->eklaim_icu_indikator->PlaceHolder = ew_RemoveHtml($this->eklaim_icu_indikator->FldCaption());

		// eklaim_icu_los
		$this->eklaim_icu_los->EditAttrs["class"] = "form-control";
		$this->eklaim_icu_los->EditCustomAttributes = "";
		$this->eklaim_icu_los->EditValue = $this->eklaim_icu_los->CurrentValue;
		$this->eklaim_icu_los->PlaceHolder = ew_RemoveHtml($this->eklaim_icu_los->FldCaption());

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour->EditAttrs["class"] = "form-control";
		$this->eklaim_ventilator_hour->EditCustomAttributes = "";
		$this->eklaim_ventilator_hour->EditValue = $this->eklaim_ventilator_hour->CurrentValue;
		$this->eklaim_ventilator_hour->PlaceHolder = ew_RemoveHtml($this->eklaim_ventilator_hour->FldCaption());

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind->EditAttrs["class"] = "form-control";
		$this->eklaim_upgrade_class_ind->EditCustomAttributes = "";
		$this->eklaim_upgrade_class_ind->EditValue = $this->eklaim_upgrade_class_ind->CurrentValue;
		$this->eklaim_upgrade_class_ind->PlaceHolder = ew_RemoveHtml($this->eklaim_upgrade_class_ind->FldCaption());

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class->EditAttrs["class"] = "form-control";
		$this->eklaim_upgrade_class_class->EditCustomAttributes = "";
		$this->eklaim_upgrade_class_class->EditValue = $this->eklaim_upgrade_class_class->CurrentValue;
		$this->eklaim_upgrade_class_class->PlaceHolder = ew_RemoveHtml($this->eklaim_upgrade_class_class->FldCaption());

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los->EditAttrs["class"] = "form-control";
		$this->eklaim_upgrade_class_los->EditCustomAttributes = "";
		$this->eklaim_upgrade_class_los->EditValue = $this->eklaim_upgrade_class_los->CurrentValue;
		$this->eklaim_upgrade_class_los->PlaceHolder = ew_RemoveHtml($this->eklaim_upgrade_class_los->FldCaption());

		// eklaim_birth_weight
		$this->eklaim_birth_weight->EditAttrs["class"] = "form-control";
		$this->eklaim_birth_weight->EditCustomAttributes = "";
		$this->eklaim_birth_weight->EditValue = $this->eklaim_birth_weight->CurrentValue;
		$this->eklaim_birth_weight->PlaceHolder = ew_RemoveHtml($this->eklaim_birth_weight->FldCaption());

		// eklaim_discharge_status
		$this->eklaim_discharge_status->EditAttrs["class"] = "form-control";
		$this->eklaim_discharge_status->EditCustomAttributes = "";
		$this->eklaim_discharge_status->EditValue = $this->eklaim_discharge_status->CurrentValue;
		$this->eklaim_discharge_status->PlaceHolder = ew_RemoveHtml($this->eklaim_discharge_status->FldCaption());

		// eklaim_diagnosa
		$this->eklaim_diagnosa->EditAttrs["class"] = "form-control";
		$this->eklaim_diagnosa->EditCustomAttributes = "";
		$this->eklaim_diagnosa->EditValue = $this->eklaim_diagnosa->CurrentValue;
		$this->eklaim_diagnosa->PlaceHolder = ew_RemoveHtml($this->eklaim_diagnosa->FldCaption());

		// eklaim_procedure
		$this->eklaim_procedure->EditAttrs["class"] = "form-control";
		$this->eklaim_procedure->EditCustomAttributes = "";
		$this->eklaim_procedure->EditValue = $this->eklaim_procedure->CurrentValue;
		$this->eklaim_procedure->PlaceHolder = ew_RemoveHtml($this->eklaim_procedure->FldCaption());

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs->EditAttrs["class"] = "form-control";
		$this->eklaim_tarif_rs->EditCustomAttributes = "";
		$this->eklaim_tarif_rs->EditValue = $this->eklaim_tarif_rs->CurrentValue;
		$this->eklaim_tarif_rs->PlaceHolder = ew_RemoveHtml($this->eklaim_tarif_rs->FldCaption());
		if (strval($this->eklaim_tarif_rs->EditValue) <> "" && is_numeric($this->eklaim_tarif_rs->EditValue)) $this->eklaim_tarif_rs->EditValue = ew_FormatNumber($this->eklaim_tarif_rs->EditValue, -2, -1, -2, 0);

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks->EditAttrs["class"] = "form-control";
		$this->eklaim_tarif_poli_eks->EditCustomAttributes = "";
		$this->eklaim_tarif_poli_eks->EditValue = $this->eklaim_tarif_poli_eks->CurrentValue;
		$this->eklaim_tarif_poli_eks->PlaceHolder = ew_RemoveHtml($this->eklaim_tarif_poli_eks->FldCaption());
		if (strval($this->eklaim_tarif_poli_eks->EditValue) <> "" && is_numeric($this->eklaim_tarif_poli_eks->EditValue)) $this->eklaim_tarif_poli_eks->EditValue = ew_FormatNumber($this->eklaim_tarif_poli_eks->EditValue, -2, -1, -2, 0);

		// eklaim_id_dokter
		$this->eklaim_id_dokter->EditAttrs["class"] = "form-control";
		$this->eklaim_id_dokter->EditCustomAttributes = "";
		$this->eklaim_id_dokter->EditValue = $this->eklaim_id_dokter->CurrentValue;
		$this->eklaim_id_dokter->PlaceHolder = ew_RemoveHtml($this->eklaim_id_dokter->FldCaption());

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter->EditAttrs["class"] = "form-control";
		$this->eklaim_nama_dokter->EditCustomAttributes = "";
		$this->eklaim_nama_dokter->EditValue = $this->eklaim_nama_dokter->CurrentValue;
		$this->eklaim_nama_dokter->PlaceHolder = ew_RemoveHtml($this->eklaim_nama_dokter->FldCaption());

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif->EditAttrs["class"] = "form-control";
		$this->eklaim_kode_tarif->EditCustomAttributes = "";
		$this->eklaim_kode_tarif->EditValue = $this->eklaim_kode_tarif->CurrentValue;
		$this->eklaim_kode_tarif->PlaceHolder = ew_RemoveHtml($this->eklaim_kode_tarif->FldCaption());

		// eklaim_payor_id
		$this->eklaim_payor_id->EditAttrs["class"] = "form-control";
		$this->eklaim_payor_id->EditCustomAttributes = "";
		$this->eklaim_payor_id->EditValue = $this->eklaim_payor_id->CurrentValue;
		$this->eklaim_payor_id->PlaceHolder = ew_RemoveHtml($this->eklaim_payor_id->FldCaption());

		// eklaim_payor_cd
		$this->eklaim_payor_cd->EditAttrs["class"] = "form-control";
		$this->eklaim_payor_cd->EditCustomAttributes = "";
		$this->eklaim_payor_cd->EditValue = $this->eklaim_payor_cd->CurrentValue;
		$this->eklaim_payor_cd->PlaceHolder = ew_RemoveHtml($this->eklaim_payor_cd->FldCaption());

		// eklaim_coder_nik
		$this->eklaim_coder_nik->EditAttrs["class"] = "form-control";
		$this->eklaim_coder_nik->EditCustomAttributes = "";
		$this->eklaim_coder_nik->EditValue = $this->eklaim_coder_nik->CurrentValue;
		$this->eklaim_coder_nik->PlaceHolder = ew_RemoveHtml($this->eklaim_coder_nik->FldCaption());

		// eklaim_los
		$this->eklaim_los->EditAttrs["class"] = "form-control";
		$this->eklaim_los->EditCustomAttributes = "";
		$this->eklaim_los->EditValue = $this->eklaim_los->CurrentValue;
		$this->eklaim_los->PlaceHolder = ew_RemoveHtml($this->eklaim_los->FldCaption());

		// eklaim_patient_id
		$this->eklaim_patient_id->EditAttrs["class"] = "form-control";
		$this->eklaim_patient_id->EditCustomAttributes = "";
		$this->eklaim_patient_id->EditValue = $this->eklaim_patient_id->CurrentValue;
		$this->eklaim_patient_id->PlaceHolder = ew_RemoveHtml($this->eklaim_patient_id->FldCaption());

		// eklaim_admission_id
		$this->eklaim_admission_id->EditAttrs["class"] = "form-control";
		$this->eklaim_admission_id->EditCustomAttributes = "";
		$this->eklaim_admission_id->EditValue = $this->eklaim_admission_id->CurrentValue;
		$this->eklaim_admission_id->PlaceHolder = ew_RemoveHtml($this->eklaim_admission_id->FldCaption());

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id->EditAttrs["class"] = "form-control";
		$this->eklaim_hospital_admission_id->EditCustomAttributes = "";
		$this->eklaim_hospital_admission_id->EditValue = $this->eklaim_hospital_admission_id->CurrentValue;
		$this->eklaim_hospital_admission_id->PlaceHolder = ew_RemoveHtml($this->eklaim_hospital_admission_id->FldCaption());

		// bridging_hapussep
		$this->bridging_hapussep->EditAttrs["class"] = "form-control";
		$this->bridging_hapussep->EditCustomAttributes = "";
		$this->bridging_hapussep->EditValue = $this->bridging_hapussep->CurrentValue;
		$this->bridging_hapussep->PlaceHolder = ew_RemoveHtml($this->bridging_hapussep->FldCaption());

		// user_penghapus_sep
		$this->user_penghapus_sep->EditAttrs["class"] = "form-control";
		$this->user_penghapus_sep->EditCustomAttributes = "";
		$this->user_penghapus_sep->EditValue = $this->user_penghapus_sep->CurrentValue;
		$this->user_penghapus_sep->PlaceHolder = ew_RemoveHtml($this->user_penghapus_sep->FldCaption());

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL->EditAttrs["class"] = "form-control";
		$this->BIAYA_BILLING_RAJAL->EditCustomAttributes = "";
		$this->BIAYA_BILLING_RAJAL->EditValue = $this->BIAYA_BILLING_RAJAL->CurrentValue;
		$this->BIAYA_BILLING_RAJAL->PlaceHolder = ew_RemoveHtml($this->BIAYA_BILLING_RAJAL->FldCaption());
		if (strval($this->BIAYA_BILLING_RAJAL->EditValue) <> "" && is_numeric($this->BIAYA_BILLING_RAJAL->EditValue)) $this->BIAYA_BILLING_RAJAL->EditValue = ew_FormatNumber($this->BIAYA_BILLING_RAJAL->EditValue, -2, -1, -2, 0);

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN->EditAttrs["class"] = "form-control";
		$this->STATUS_PEMBAYARAN->EditCustomAttributes = "";
		$this->STATUS_PEMBAYARAN->EditValue = $this->STATUS_PEMBAYARAN->CurrentValue;
		$this->STATUS_PEMBAYARAN->PlaceHolder = ew_RemoveHtml($this->STATUS_PEMBAYARAN->FldCaption());

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_FISIOTERAPI->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_FISIOTERAPI->EditValue = $this->BIAYA_TINDAKAN_FISIOTERAPI->CurrentValue;
		$this->BIAYA_TINDAKAN_FISIOTERAPI->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_FISIOTERAPI->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_FISIOTERAPI->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_FISIOTERAPI->EditValue)) $this->BIAYA_TINDAKAN_FISIOTERAPI->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_FISIOTERAPI->EditValue, -2, -1, -2, 0);

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien->EditAttrs["class"] = "form-control";
		$this->eklaim_reg_pasien->EditCustomAttributes = "";
		$this->eklaim_reg_pasien->EditValue = $this->eklaim_reg_pasien->CurrentValue;
		$this->eklaim_reg_pasien->PlaceHolder = ew_RemoveHtml($this->eklaim_reg_pasien->FldCaption());

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru->EditAttrs["class"] = "form-control";
		$this->eklaim_reg_klaim_baru->EditCustomAttributes = "";
		$this->eklaim_reg_klaim_baru->EditValue = $this->eklaim_reg_klaim_baru->CurrentValue;
		$this->eklaim_reg_klaim_baru->PlaceHolder = ew_RemoveHtml($this->eklaim_reg_klaim_baru->FldCaption());

		// eklaim_gruper1
		$this->eklaim_gruper1->EditAttrs["class"] = "form-control";
		$this->eklaim_gruper1->EditCustomAttributes = "";
		$this->eklaim_gruper1->EditValue = $this->eklaim_gruper1->CurrentValue;
		$this->eklaim_gruper1->PlaceHolder = ew_RemoveHtml($this->eklaim_gruper1->FldCaption());

		// eklaim_gruper2
		$this->eklaim_gruper2->EditAttrs["class"] = "form-control";
		$this->eklaim_gruper2->EditCustomAttributes = "";
		$this->eklaim_gruper2->EditValue = $this->eklaim_gruper2->CurrentValue;
		$this->eklaim_gruper2->PlaceHolder = ew_RemoveHtml($this->eklaim_gruper2->FldCaption());

		// eklaim_finalklaim
		$this->eklaim_finalklaim->EditAttrs["class"] = "form-control";
		$this->eklaim_finalklaim->EditCustomAttributes = "";
		$this->eklaim_finalklaim->EditValue = $this->eklaim_finalklaim->CurrentValue;
		$this->eklaim_finalklaim->PlaceHolder = ew_RemoveHtml($this->eklaim_finalklaim->FldCaption());

		// eklaim_sendklaim
		$this->eklaim_sendklaim->EditAttrs["class"] = "form-control";
		$this->eklaim_sendklaim->EditCustomAttributes = "";
		$this->eklaim_sendklaim->EditValue = $this->eklaim_sendklaim->CurrentValue;
		$this->eklaim_sendklaim->PlaceHolder = ew_RemoveHtml($this->eklaim_sendklaim->FldCaption());

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien->EditAttrs["class"] = "form-control";
		$this->eklaim_flag_hapus_pasien->EditCustomAttributes = "";
		$this->eklaim_flag_hapus_pasien->EditValue = $this->eklaim_flag_hapus_pasien->CurrentValue;
		$this->eklaim_flag_hapus_pasien->PlaceHolder = ew_RemoveHtml($this->eklaim_flag_hapus_pasien->FldCaption());

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim->EditAttrs["class"] = "form-control";
		$this->eklaim_flag_hapus_klaim->EditCustomAttributes = "";
		$this->eklaim_flag_hapus_klaim->EditValue = $this->eklaim_flag_hapus_klaim->CurrentValue;
		$this->eklaim_flag_hapus_klaim->PlaceHolder = ew_RemoveHtml($this->eklaim_flag_hapus_klaim->FldCaption());

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status->EditAttrs["class"] = "form-control";
		$this->eklaim_kemkes_dc_Status->EditCustomAttributes = "";
		$this->eklaim_kemkes_dc_Status->EditValue = $this->eklaim_kemkes_dc_Status->CurrentValue;
		$this->eklaim_kemkes_dc_Status->PlaceHolder = ew_RemoveHtml($this->eklaim_kemkes_dc_Status->FldCaption());

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status->EditAttrs["class"] = "form-control";
		$this->eklaim_bpjs_dc_Status->EditCustomAttributes = "";
		$this->eklaim_bpjs_dc_Status->EditValue = $this->eklaim_bpjs_dc_Status->CurrentValue;
		$this->eklaim_bpjs_dc_Status->PlaceHolder = ew_RemoveHtml($this->eklaim_bpjs_dc_Status->FldCaption());

		// eklaim_cbg_code
		$this->eklaim_cbg_code->EditAttrs["class"] = "form-control";
		$this->eklaim_cbg_code->EditCustomAttributes = "";
		$this->eklaim_cbg_code->EditValue = $this->eklaim_cbg_code->CurrentValue;
		$this->eklaim_cbg_code->PlaceHolder = ew_RemoveHtml($this->eklaim_cbg_code->FldCaption());

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition->EditAttrs["class"] = "form-control";
		$this->eklaim_cbg_descprition->EditCustomAttributes = "";
		$this->eklaim_cbg_descprition->EditValue = $this->eklaim_cbg_descprition->CurrentValue;
		$this->eklaim_cbg_descprition->PlaceHolder = ew_RemoveHtml($this->eklaim_cbg_descprition->FldCaption());

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff->EditAttrs["class"] = "form-control";
		$this->eklaim_cbg_tariff->EditCustomAttributes = "";
		$this->eklaim_cbg_tariff->EditValue = $this->eklaim_cbg_tariff->CurrentValue;
		$this->eklaim_cbg_tariff->PlaceHolder = ew_RemoveHtml($this->eklaim_cbg_tariff->FldCaption());
		if (strval($this->eklaim_cbg_tariff->EditValue) <> "" && is_numeric($this->eklaim_cbg_tariff->EditValue)) $this->eklaim_cbg_tariff->EditValue = ew_FormatNumber($this->eklaim_cbg_tariff->EditValue, -2, -1, -2, 0);

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code->EditAttrs["class"] = "form-control";
		$this->eklaim_sub_acute_code->EditCustomAttributes = "";
		$this->eklaim_sub_acute_code->EditValue = $this->eklaim_sub_acute_code->CurrentValue;
		$this->eklaim_sub_acute_code->PlaceHolder = ew_RemoveHtml($this->eklaim_sub_acute_code->FldCaption());

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi->EditAttrs["class"] = "form-control";
		$this->eklaim_sub_acute_deskripsi->EditCustomAttributes = "";
		$this->eklaim_sub_acute_deskripsi->EditValue = $this->eklaim_sub_acute_deskripsi->CurrentValue;
		$this->eklaim_sub_acute_deskripsi->PlaceHolder = ew_RemoveHtml($this->eklaim_sub_acute_deskripsi->FldCaption());

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff->EditAttrs["class"] = "form-control";
		$this->eklaim_sub_acute_tariff->EditCustomAttributes = "";
		$this->eklaim_sub_acute_tariff->EditValue = $this->eklaim_sub_acute_tariff->CurrentValue;
		$this->eklaim_sub_acute_tariff->PlaceHolder = ew_RemoveHtml($this->eklaim_sub_acute_tariff->FldCaption());
		if (strval($this->eklaim_sub_acute_tariff->EditValue) <> "" && is_numeric($this->eklaim_sub_acute_tariff->EditValue)) $this->eklaim_sub_acute_tariff->EditValue = ew_FormatNumber($this->eklaim_sub_acute_tariff->EditValue, -2, -1, -2, 0);

		// eklaim_chronic_code
		$this->eklaim_chronic_code->EditAttrs["class"] = "form-control";
		$this->eklaim_chronic_code->EditCustomAttributes = "";
		$this->eklaim_chronic_code->EditValue = $this->eklaim_chronic_code->CurrentValue;
		$this->eklaim_chronic_code->PlaceHolder = ew_RemoveHtml($this->eklaim_chronic_code->FldCaption());

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi->EditAttrs["class"] = "form-control";
		$this->eklaim_chronic_deskripsi->EditCustomAttributes = "";
		$this->eklaim_chronic_deskripsi->EditValue = $this->eklaim_chronic_deskripsi->CurrentValue;
		$this->eklaim_chronic_deskripsi->PlaceHolder = ew_RemoveHtml($this->eklaim_chronic_deskripsi->FldCaption());

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff->EditAttrs["class"] = "form-control";
		$this->eklaim_chronic_tariff->EditCustomAttributes = "";
		$this->eklaim_chronic_tariff->EditValue = $this->eklaim_chronic_tariff->CurrentValue;
		$this->eklaim_chronic_tariff->PlaceHolder = ew_RemoveHtml($this->eklaim_chronic_tariff->FldCaption());
		if (strval($this->eklaim_chronic_tariff->EditValue) <> "" && is_numeric($this->eklaim_chronic_tariff->EditValue)) $this->eklaim_chronic_tariff->EditValue = ew_FormatNumber($this->eklaim_chronic_tariff->EditValue, -2, -1, -2, 0);

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version->EditAttrs["class"] = "form-control";
		$this->eklaim_inacbg_version->EditCustomAttributes = "";
		$this->eklaim_inacbg_version->EditValue = $this->eklaim_inacbg_version->CurrentValue;
		$this->eklaim_inacbg_version->PlaceHolder = ew_RemoveHtml($this->eklaim_inacbg_version->FldCaption());

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_IBS_RAJAL->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_IBS_RAJAL->EditValue = $this->BIAYA_TINDAKAN_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_IBS_RAJAL->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_IBS_RAJAL->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_IBS_RAJAL->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_IBS_RAJAL->EditValue)) $this->BIAYA_TINDAKAN_IBS_RAJAL->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_IBS_RAJAL->EditValue, -2, -1, -2, 0);

		// VERIFY_ICD
		$this->VERIFY_ICD->EditAttrs["class"] = "form-control";
		$this->VERIFY_ICD->EditCustomAttributes = "";
		$this->VERIFY_ICD->EditValue = $this->VERIFY_ICD->CurrentValue;
		$this->VERIFY_ICD->PlaceHolder = ew_RemoveHtml($this->VERIFY_ICD->FldCaption());

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->EditAttrs["class"] = "form-control";
		$this->bridging_rujukan_faskes_2->EditCustomAttributes = "";
		$this->bridging_rujukan_faskes_2->EditValue = $this->bridging_rujukan_faskes_2->CurrentValue;
		$this->bridging_rujukan_faskes_2->PlaceHolder = ew_RemoveHtml($this->bridging_rujukan_faskes_2->FldCaption());

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim->EditAttrs["class"] = "form-control";
		$this->eklaim_reedit_claim->EditCustomAttributes = "";
		$this->eklaim_reedit_claim->EditValue = $this->eklaim_reedit_claim->CurrentValue;
		$this->eklaim_reedit_claim->PlaceHolder = ew_RemoveHtml($this->eklaim_reedit_claim->FldCaption());

		// KETERANGAN
		$this->KETERANGAN->EditAttrs["class"] = "form-control";
		$this->KETERANGAN->EditCustomAttributes = "";
		$this->KETERANGAN->EditValue = $this->KETERANGAN->CurrentValue;
		$this->KETERANGAN->PlaceHolder = ew_RemoveHtml($this->KETERANGAN->FldCaption());

		// TGLLAHIR
		$this->TGLLAHIR->EditAttrs["class"] = "form-control";
		$this->TGLLAHIR->EditCustomAttributes = "";
		$this->TGLLAHIR->EditValue = ew_FormatDateTime($this->TGLLAHIR->CurrentValue, 8);
		$this->TGLLAHIR->PlaceHolder = ew_RemoveHtml($this->TGLLAHIR->FldCaption());

		// USER_KASIR
		$this->USER_KASIR->EditAttrs["class"] = "form-control";
		$this->USER_KASIR->EditCustomAttributes = "";
		$this->USER_KASIR->EditValue = $this->USER_KASIR->CurrentValue;
		$this->USER_KASIR->PlaceHolder = ew_RemoveHtml($this->USER_KASIR->FldCaption());

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping->EditAttrs["class"] = "form-control";
		$this->eklaim_tgl_gruping->EditCustomAttributes = "";
		$this->eklaim_tgl_gruping->EditValue = ew_FormatDateTime($this->eklaim_tgl_gruping->CurrentValue, 8);
		$this->eklaim_tgl_gruping->PlaceHolder = ew_RemoveHtml($this->eklaim_tgl_gruping->FldCaption());

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim->EditAttrs["class"] = "form-control";
		$this->eklaim_tgl_finalklaim->EditCustomAttributes = "";
		$this->eklaim_tgl_finalklaim->EditValue = ew_FormatDateTime($this->eklaim_tgl_finalklaim->CurrentValue, 8);
		$this->eklaim_tgl_finalklaim->PlaceHolder = ew_RemoveHtml($this->eklaim_tgl_finalklaim->FldCaption());

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim->EditAttrs["class"] = "form-control";
		$this->eklaim_tgl_kirim_klaim->EditCustomAttributes = "";
		$this->eklaim_tgl_kirim_klaim->EditValue = ew_FormatDateTime($this->eklaim_tgl_kirim_klaim->CurrentValue, 8);
		$this->eklaim_tgl_kirim_klaim->PlaceHolder = ew_RemoveHtml($this->eklaim_tgl_kirim_klaim->FldCaption());

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS->EditAttrs["class"] = "form-control";
		$this->BIAYA_OBAT_RS->EditCustomAttributes = "";
		$this->BIAYA_OBAT_RS->EditValue = $this->BIAYA_OBAT_RS->CurrentValue;
		$this->BIAYA_OBAT_RS->PlaceHolder = ew_RemoveHtml($this->BIAYA_OBAT_RS->FldCaption());
		if (strval($this->BIAYA_OBAT_RS->EditValue) <> "" && is_numeric($this->BIAYA_OBAT_RS->EditValue)) $this->BIAYA_OBAT_RS->EditValue = ew_FormatNumber($this->BIAYA_OBAT_RS->EditValue, -2, -1, -2, 0);

		// EKG_RAJAL
		$this->EKG_RAJAL->EditAttrs["class"] = "form-control";
		$this->EKG_RAJAL->EditCustomAttributes = "";
		$this->EKG_RAJAL->EditValue = $this->EKG_RAJAL->CurrentValue;
		$this->EKG_RAJAL->PlaceHolder = ew_RemoveHtml($this->EKG_RAJAL->FldCaption());
		if (strval($this->EKG_RAJAL->EditValue) <> "" && is_numeric($this->EKG_RAJAL->EditValue)) $this->EKG_RAJAL->EditValue = ew_FormatNumber($this->EKG_RAJAL->EditValue, -2, -1, -2, 0);

		// USG_RAJAL
		$this->USG_RAJAL->EditAttrs["class"] = "form-control";
		$this->USG_RAJAL->EditCustomAttributes = "";
		$this->USG_RAJAL->EditValue = $this->USG_RAJAL->CurrentValue;
		$this->USG_RAJAL->PlaceHolder = ew_RemoveHtml($this->USG_RAJAL->FldCaption());
		if (strval($this->USG_RAJAL->EditValue) <> "" && is_numeric($this->USG_RAJAL->EditValue)) $this->USG_RAJAL->EditValue = ew_FormatNumber($this->USG_RAJAL->EditValue, -2, -1, -2, 0);

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL->EditAttrs["class"] = "form-control";
		$this->FISIOTERAPI_RAJAL->EditCustomAttributes = "";
		$this->FISIOTERAPI_RAJAL->EditValue = $this->FISIOTERAPI_RAJAL->CurrentValue;
		$this->FISIOTERAPI_RAJAL->PlaceHolder = ew_RemoveHtml($this->FISIOTERAPI_RAJAL->FldCaption());
		if (strval($this->FISIOTERAPI_RAJAL->EditValue) <> "" && is_numeric($this->FISIOTERAPI_RAJAL->EditValue)) $this->FISIOTERAPI_RAJAL->EditValue = ew_FormatNumber($this->FISIOTERAPI_RAJAL->EditValue, -2, -1, -2, 0);

		// BHP_RAJAL
		$this->BHP_RAJAL->EditAttrs["class"] = "form-control";
		$this->BHP_RAJAL->EditCustomAttributes = "";
		$this->BHP_RAJAL->EditValue = $this->BHP_RAJAL->CurrentValue;
		$this->BHP_RAJAL->PlaceHolder = ew_RemoveHtml($this->BHP_RAJAL->FldCaption());
		if (strval($this->BHP_RAJAL->EditValue) <> "" && is_numeric($this->BHP_RAJAL->EditValue)) $this->BHP_RAJAL->EditValue = ew_FormatNumber($this->BHP_RAJAL->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->EditValue = $this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->EditValue)) $this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->EditValue = $this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->EditValue)) $this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->EditValue, -2, -1, -2, 0);

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL->EditAttrs["class"] = "form-control";
		$this->TOTAL_BIAYA_IBS_RAJAL->EditCustomAttributes = "";
		$this->TOTAL_BIAYA_IBS_RAJAL->EditValue = $this->TOTAL_BIAYA_IBS_RAJAL->CurrentValue;
		$this->TOTAL_BIAYA_IBS_RAJAL->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_IBS_RAJAL->FldCaption());
		if (strval($this->TOTAL_BIAYA_IBS_RAJAL->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_IBS_RAJAL->EditValue)) $this->TOTAL_BIAYA_IBS_RAJAL->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_IBS_RAJAL->EditValue, -2, -1, -2, 0);

		// ORDER_LAB
		$this->ORDER_LAB->EditAttrs["class"] = "form-control";
		$this->ORDER_LAB->EditCustomAttributes = "";
		$this->ORDER_LAB->EditValue = $this->ORDER_LAB->CurrentValue;
		$this->ORDER_LAB->PlaceHolder = ew_RemoveHtml($this->ORDER_LAB->FldCaption());

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI->EditAttrs["class"] = "form-control";
		$this->BILL_RAJAL_SELESAI->EditCustomAttributes = "";
		$this->BILL_RAJAL_SELESAI->EditValue = $this->BILL_RAJAL_SELESAI->CurrentValue;
		$this->BILL_RAJAL_SELESAI->PlaceHolder = ew_RemoveHtml($this->BILL_RAJAL_SELESAI->FldCaption());

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR->EditAttrs["class"] = "form-control";
		$this->INCLUDE_IDXDAFTAR->EditCustomAttributes = "";
		$this->INCLUDE_IDXDAFTAR->EditValue = $this->INCLUDE_IDXDAFTAR->CurrentValue;
		$this->INCLUDE_IDXDAFTAR->PlaceHolder = ew_RemoveHtml($this->INCLUDE_IDXDAFTAR->FldCaption());

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA->EditAttrs["class"] = "form-control";
		$this->INCLUDE_HARGA->EditCustomAttributes = "";
		$this->INCLUDE_HARGA->EditValue = $this->INCLUDE_HARGA->CurrentValue;
		$this->INCLUDE_HARGA->PlaceHolder = ew_RemoveHtml($this->INCLUDE_HARGA->FldCaption());
		if (strval($this->INCLUDE_HARGA->EditValue) <> "" && is_numeric($this->INCLUDE_HARGA->EditValue)) $this->INCLUDE_HARGA->EditValue = ew_FormatNumber($this->INCLUDE_HARGA->EditValue, -2, -1, -2, 0);

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA->EditAttrs["class"] = "form-control";
		$this->TARIF_JASA_SARANA->EditCustomAttributes = "";
		$this->TARIF_JASA_SARANA->EditValue = $this->TARIF_JASA_SARANA->CurrentValue;
		$this->TARIF_JASA_SARANA->PlaceHolder = ew_RemoveHtml($this->TARIF_JASA_SARANA->FldCaption());
		if (strval($this->TARIF_JASA_SARANA->EditValue) <> "" && is_numeric($this->TARIF_JASA_SARANA->EditValue)) $this->TARIF_JASA_SARANA->EditValue = ew_FormatNumber($this->TARIF_JASA_SARANA->EditValue, -2, -1, -2, 0);

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS->EditAttrs["class"] = "form-control";
		$this->TARIF_PENUNJANG_NON_MEDIS->EditCustomAttributes = "";
		$this->TARIF_PENUNJANG_NON_MEDIS->EditValue = $this->TARIF_PENUNJANG_NON_MEDIS->CurrentValue;
		$this->TARIF_PENUNJANG_NON_MEDIS->PlaceHolder = ew_RemoveHtml($this->TARIF_PENUNJANG_NON_MEDIS->FldCaption());
		if (strval($this->TARIF_PENUNJANG_NON_MEDIS->EditValue) <> "" && is_numeric($this->TARIF_PENUNJANG_NON_MEDIS->EditValue)) $this->TARIF_PENUNJANG_NON_MEDIS->EditValue = ew_FormatNumber($this->TARIF_PENUNJANG_NON_MEDIS->EditValue, -2, -1, -2, 0);

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN->EditAttrs["class"] = "form-control";
		$this->TARIF_ASUHAN_KEPERAWATAN->EditCustomAttributes = "";
		$this->TARIF_ASUHAN_KEPERAWATAN->EditValue = $this->TARIF_ASUHAN_KEPERAWATAN->CurrentValue;
		$this->TARIF_ASUHAN_KEPERAWATAN->PlaceHolder = ew_RemoveHtml($this->TARIF_ASUHAN_KEPERAWATAN->FldCaption());
		if (strval($this->TARIF_ASUHAN_KEPERAWATAN->EditValue) <> "" && is_numeric($this->TARIF_ASUHAN_KEPERAWATAN->EditValue)) $this->TARIF_ASUHAN_KEPERAWATAN->EditValue = ew_FormatNumber($this->TARIF_ASUHAN_KEPERAWATAN->EditValue, -2, -1, -2, 0);

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL->EditAttrs["class"] = "form-control";
		$this->KDDOKTER_RAJAL->EditCustomAttributes = "";
		$this->KDDOKTER_RAJAL->EditValue = $this->KDDOKTER_RAJAL->CurrentValue;
		$this->KDDOKTER_RAJAL->PlaceHolder = ew_RemoveHtml($this->KDDOKTER_RAJAL->FldCaption());

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL->EditAttrs["class"] = "form-control";
		$this->KDDOKTER_KONSUL_RAJAL->EditCustomAttributes = "";
		$this->KDDOKTER_KONSUL_RAJAL->EditValue = $this->KDDOKTER_KONSUL_RAJAL->CurrentValue;
		$this->KDDOKTER_KONSUL_RAJAL->PlaceHolder = ew_RemoveHtml($this->KDDOKTER_KONSUL_RAJAL->FldCaption());

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS->EditAttrs["class"] = "form-control";
		$this->BIAYA_BILLING_RS->EditCustomAttributes = "";
		$this->BIAYA_BILLING_RS->EditValue = $this->BIAYA_BILLING_RS->CurrentValue;
		$this->BIAYA_BILLING_RS->PlaceHolder = ew_RemoveHtml($this->BIAYA_BILLING_RS->FldCaption());
		if (strval($this->BIAYA_BILLING_RS->EditValue) <> "" && is_numeric($this->BIAYA_BILLING_RS->EditValue)) $this->BIAYA_BILLING_RS->EditValue = ew_FormatNumber($this->BIAYA_BILLING_RS->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_POLI_TMO->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_POLI_TMO->EditValue = $this->BIAYA_TINDAKAN_POLI_TMO->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_TMO->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_POLI_TMO->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_POLI_TMO->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_POLI_TMO->EditValue)) $this->BIAYA_TINDAKAN_POLI_TMO->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_POLI_TMO->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->EditValue = $this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->EditValue)) $this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->EditValue, -2, -1, -2, 0);

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO->EditAttrs["class"] = "form-control";
		$this->BHP_RAJAL_TMO->EditCustomAttributes = "";
		$this->BHP_RAJAL_TMO->EditValue = $this->BHP_RAJAL_TMO->CurrentValue;
		$this->BHP_RAJAL_TMO->PlaceHolder = ew_RemoveHtml($this->BHP_RAJAL_TMO->FldCaption());
		if (strval($this->BHP_RAJAL_TMO->EditValue) <> "" && is_numeric($this->BHP_RAJAL_TMO->EditValue)) $this->BHP_RAJAL_TMO->EditValue = ew_FormatNumber($this->BHP_RAJAL_TMO->EditValue, -2, -1, -2, 0);

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN->EditAttrs["class"] = "form-control";
		$this->BHP_RAJAL_KEPERAWATAN->EditCustomAttributes = "";
		$this->BHP_RAJAL_KEPERAWATAN->EditValue = $this->BHP_RAJAL_KEPERAWATAN->CurrentValue;
		$this->BHP_RAJAL_KEPERAWATAN->PlaceHolder = ew_RemoveHtml($this->BHP_RAJAL_KEPERAWATAN->FldCaption());
		if (strval($this->BHP_RAJAL_KEPERAWATAN->EditValue) <> "" && is_numeric($this->BHP_RAJAL_KEPERAWATAN->EditValue)) $this->BHP_RAJAL_KEPERAWATAN->EditValue = ew_FormatNumber($this->BHP_RAJAL_KEPERAWATAN->EditValue, -2, -1, -2, 0);

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI->EditAttrs["class"] = "form-control";
		$this->TARIF_AKOMODASI->EditCustomAttributes = "";
		$this->TARIF_AKOMODASI->EditValue = $this->TARIF_AKOMODASI->CurrentValue;
		$this->TARIF_AKOMODASI->PlaceHolder = ew_RemoveHtml($this->TARIF_AKOMODASI->FldCaption());
		if (strval($this->TARIF_AKOMODASI->EditValue) <> "" && is_numeric($this->TARIF_AKOMODASI->EditValue)) $this->TARIF_AKOMODASI->EditValue = ew_FormatNumber($this->TARIF_AKOMODASI->EditValue, -2, -1, -2, 0);

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN->EditAttrs["class"] = "form-control";
		$this->TARIF_AMBULAN->EditCustomAttributes = "";
		$this->TARIF_AMBULAN->EditValue = $this->TARIF_AMBULAN->CurrentValue;
		$this->TARIF_AMBULAN->PlaceHolder = ew_RemoveHtml($this->TARIF_AMBULAN->FldCaption());
		if (strval($this->TARIF_AMBULAN->EditValue) <> "" && is_numeric($this->TARIF_AMBULAN->EditValue)) $this->TARIF_AMBULAN->EditValue = ew_FormatNumber($this->TARIF_AMBULAN->EditValue, -2, -1, -2, 0);

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN->EditAttrs["class"] = "form-control";
		$this->TARIF_OKSIGEN->EditCustomAttributes = "";
		$this->TARIF_OKSIGEN->EditValue = $this->TARIF_OKSIGEN->CurrentValue;
		$this->TARIF_OKSIGEN->PlaceHolder = ew_RemoveHtml($this->TARIF_OKSIGEN->FldCaption());
		if (strval($this->TARIF_OKSIGEN->EditValue) <> "" && is_numeric($this->TARIF_OKSIGEN->EditValue)) $this->TARIF_OKSIGEN->EditValue = ew_FormatNumber($this->TARIF_OKSIGEN->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_JENAZAH->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_JENAZAH->EditValue = $this->BIAYA_TINDAKAN_JENAZAH->CurrentValue;
		$this->BIAYA_TINDAKAN_JENAZAH->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_JENAZAH->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_JENAZAH->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_JENAZAH->EditValue)) $this->BIAYA_TINDAKAN_JENAZAH->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_JENAZAH->EditValue, -2, -1, -2, 0);

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD->EditAttrs["class"] = "form-control";
		$this->BIAYA_BILLING_IGD->EditCustomAttributes = "";
		$this->BIAYA_BILLING_IGD->EditValue = $this->BIAYA_BILLING_IGD->CurrentValue;
		$this->BIAYA_BILLING_IGD->PlaceHolder = ew_RemoveHtml($this->BIAYA_BILLING_IGD->FldCaption());
		if (strval($this->BIAYA_BILLING_IGD->EditValue) <> "" && is_numeric($this->BIAYA_BILLING_IGD->EditValue)) $this->BIAYA_BILLING_IGD->EditValue = ew_FormatNumber($this->BIAYA_BILLING_IGD->EditValue, -2, -1, -2, 0);

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->EditAttrs["class"] = "form-control";
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->EditCustomAttributes = "";
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->EditValue = $this->BIAYA_TINDAKAN_POLI_PERSALINAN->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->PlaceHolder = ew_RemoveHtml($this->BIAYA_TINDAKAN_POLI_PERSALINAN->FldCaption());
		if (strval($this->BIAYA_TINDAKAN_POLI_PERSALINAN->EditValue) <> "" && is_numeric($this->BIAYA_TINDAKAN_POLI_PERSALINAN->EditValue)) $this->BIAYA_TINDAKAN_POLI_PERSALINAN->EditValue = ew_FormatNumber($this->BIAYA_TINDAKAN_POLI_PERSALINAN->EditValue, -2, -1, -2, 0);

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN->EditAttrs["class"] = "form-control";
		$this->BHP_RAJAL_PERSALINAN->EditCustomAttributes = "";
		$this->BHP_RAJAL_PERSALINAN->EditValue = $this->BHP_RAJAL_PERSALINAN->CurrentValue;
		$this->BHP_RAJAL_PERSALINAN->PlaceHolder = ew_RemoveHtml($this->BHP_RAJAL_PERSALINAN->FldCaption());
		if (strval($this->BHP_RAJAL_PERSALINAN->EditValue) <> "" && is_numeric($this->BHP_RAJAL_PERSALINAN->EditValue)) $this->BHP_RAJAL_PERSALINAN->EditValue = ew_FormatNumber($this->BHP_RAJAL_PERSALINAN->EditValue, -2, -1, -2, 0);

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI->EditAttrs["class"] = "form-control";
		$this->TARIF_BIMBINGAN_ROHANI->EditCustomAttributes = "";
		$this->TARIF_BIMBINGAN_ROHANI->EditValue = $this->TARIF_BIMBINGAN_ROHANI->CurrentValue;
		$this->TARIF_BIMBINGAN_ROHANI->PlaceHolder = ew_RemoveHtml($this->TARIF_BIMBINGAN_ROHANI->FldCaption());
		if (strval($this->TARIF_BIMBINGAN_ROHANI->EditValue) <> "" && is_numeric($this->TARIF_BIMBINGAN_ROHANI->EditValue)) $this->TARIF_BIMBINGAN_ROHANI->EditValue = ew_FormatNumber($this->TARIF_BIMBINGAN_ROHANI->EditValue, -2, -1, -2, 0);

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2->EditAttrs["class"] = "form-control";
		$this->BIAYA_BILLING_RS2->EditCustomAttributes = "";
		$this->BIAYA_BILLING_RS2->EditValue = $this->BIAYA_BILLING_RS2->CurrentValue;
		$this->BIAYA_BILLING_RS2->PlaceHolder = ew_RemoveHtml($this->BIAYA_BILLING_RS2->FldCaption());
		if (strval($this->BIAYA_BILLING_RS2->EditValue) <> "" && is_numeric($this->BIAYA_BILLING_RS2->EditValue)) $this->BIAYA_BILLING_RS2->EditValue = ew_FormatNumber($this->BIAYA_BILLING_RS2->EditValue, -2, -1, -2, 0);

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD->EditAttrs["class"] = "form-control";
		$this->BIAYA_TARIF_DOKTER_IGD->EditCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER_IGD->EditValue = $this->BIAYA_TARIF_DOKTER_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_IGD->PlaceHolder = ew_RemoveHtml($this->BIAYA_TARIF_DOKTER_IGD->FldCaption());
		if (strval($this->BIAYA_TARIF_DOKTER_IGD->EditValue) <> "" && is_numeric($this->BIAYA_TARIF_DOKTER_IGD->EditValue)) $this->BIAYA_TARIF_DOKTER_IGD->EditValue = ew_FormatNumber($this->BIAYA_TARIF_DOKTER_IGD->EditValue, -2, -1, -2, 0);

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD->EditAttrs["class"] = "form-control";
		$this->BIAYA_PENDAFTARAN_IGD->EditCustomAttributes = "";
		$this->BIAYA_PENDAFTARAN_IGD->EditValue = $this->BIAYA_PENDAFTARAN_IGD->CurrentValue;
		$this->BIAYA_PENDAFTARAN_IGD->PlaceHolder = ew_RemoveHtml($this->BIAYA_PENDAFTARAN_IGD->FldCaption());
		if (strval($this->BIAYA_PENDAFTARAN_IGD->EditValue) <> "" && is_numeric($this->BIAYA_PENDAFTARAN_IGD->EditValue)) $this->BIAYA_PENDAFTARAN_IGD->EditValue = ew_FormatNumber($this->BIAYA_PENDAFTARAN_IGD->EditValue, -2, -1, -2, 0);

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS->EditAttrs["class"] = "form-control";
		$this->BIAYA_BILLING_IBS->EditCustomAttributes = "";
		$this->BIAYA_BILLING_IBS->EditValue = $this->BIAYA_BILLING_IBS->CurrentValue;
		$this->BIAYA_BILLING_IBS->PlaceHolder = ew_RemoveHtml($this->BIAYA_BILLING_IBS->FldCaption());
		if (strval($this->BIAYA_BILLING_IBS->EditValue) <> "" && is_numeric($this->BIAYA_BILLING_IBS->EditValue)) $this->BIAYA_BILLING_IBS->EditValue = ew_FormatNumber($this->BIAYA_BILLING_IBS->EditValue, -2, -1, -2, 0);

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD->EditAttrs["class"] = "form-control";
		$this->TARIF_JASA_SARANA_IGD->EditCustomAttributes = "";
		$this->TARIF_JASA_SARANA_IGD->EditValue = $this->TARIF_JASA_SARANA_IGD->CurrentValue;
		$this->TARIF_JASA_SARANA_IGD->PlaceHolder = ew_RemoveHtml($this->TARIF_JASA_SARANA_IGD->FldCaption());
		if (strval($this->TARIF_JASA_SARANA_IGD->EditValue) <> "" && is_numeric($this->TARIF_JASA_SARANA_IGD->EditValue)) $this->TARIF_JASA_SARANA_IGD->EditValue = ew_FormatNumber($this->TARIF_JASA_SARANA_IGD->EditValue, -2, -1, -2, 0);

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->EditAttrs["class"] = "form-control";
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->EditCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->EditValue = $this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->PlaceHolder = ew_RemoveHtml($this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->FldCaption());
		if (strval($this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->EditValue) <> "" && is_numeric($this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->EditValue)) $this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->EditValue = ew_FormatNumber($this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->EditValue, -2, -1, -2, 0);

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->EditAttrs["class"] = "form-control";
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->EditCustomAttributes = "";
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->EditValue = $this->BIAYA_TARIF_DOKTER_KONSUL_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->PlaceHolder = ew_RemoveHtml($this->BIAYA_TARIF_DOKTER_KONSUL_IGD->FldCaption());
		if (strval($this->BIAYA_TARIF_DOKTER_KONSUL_IGD->EditValue) <> "" && is_numeric($this->BIAYA_TARIF_DOKTER_KONSUL_IGD->EditValue)) $this->BIAYA_TARIF_DOKTER_KONSUL_IGD->EditValue = ew_FormatNumber($this->BIAYA_TARIF_DOKTER_KONSUL_IGD->EditValue, -2, -1, -2, 0);

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD->EditAttrs["class"] = "form-control";
		$this->TARIF_MAKAN_IGD->EditCustomAttributes = "";
		$this->TARIF_MAKAN_IGD->EditValue = $this->TARIF_MAKAN_IGD->CurrentValue;
		$this->TARIF_MAKAN_IGD->PlaceHolder = ew_RemoveHtml($this->TARIF_MAKAN_IGD->FldCaption());
		if (strval($this->TARIF_MAKAN_IGD->EditValue) <> "" && is_numeric($this->TARIF_MAKAN_IGD->EditValue)) $this->TARIF_MAKAN_IGD->EditValue = ew_FormatNumber($this->TARIF_MAKAN_IGD->EditValue, -2, -1, -2, 0);

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->EditAttrs["class"] = "form-control";
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->EditCustomAttributes = "";
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->EditValue = $this->TARIF_ASUHAN_KEPERAWATAN_IGD->CurrentValue;
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->PlaceHolder = ew_RemoveHtml($this->TARIF_ASUHAN_KEPERAWATAN_IGD->FldCaption());
		if (strval($this->TARIF_ASUHAN_KEPERAWATAN_IGD->EditValue) <> "" && is_numeric($this->TARIF_ASUHAN_KEPERAWATAN_IGD->EditValue)) $this->TARIF_ASUHAN_KEPERAWATAN_IGD->EditValue = ew_FormatNumber($this->TARIF_ASUHAN_KEPERAWATAN_IGD->EditValue, -2, -1, -2, 0);

		// pasien_TITLE
		$this->pasien_TITLE->EditAttrs["class"] = "form-control";
		$this->pasien_TITLE->EditCustomAttributes = "";

		// pasien_NAMA
		$this->pasien_NAMA->EditAttrs["class"] = "form-control";
		$this->pasien_NAMA->EditCustomAttributes = "";
		$this->pasien_NAMA->EditValue = $this->pasien_NAMA->CurrentValue;
		$this->pasien_NAMA->PlaceHolder = ew_RemoveHtml($this->pasien_NAMA->FldCaption());

		// pasien_TEMPAT
		$this->pasien_TEMPAT->EditAttrs["class"] = "form-control";
		$this->pasien_TEMPAT->EditCustomAttributes = "";
		$this->pasien_TEMPAT->EditValue = $this->pasien_TEMPAT->CurrentValue;
		$this->pasien_TEMPAT->PlaceHolder = ew_RemoveHtml($this->pasien_TEMPAT->FldCaption());

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->EditAttrs["class"] = "form-control";
		$this->pasien_TGLLAHIR->EditCustomAttributes = "";
		$this->pasien_TGLLAHIR->EditValue = ew_FormatDateTime($this->pasien_TGLLAHIR->CurrentValue, 7);
		$this->pasien_TGLLAHIR->PlaceHolder = ew_RemoveHtml($this->pasien_TGLLAHIR->FldCaption());

		// pasien_JENISKELAMIN
		$this->pasien_JENISKELAMIN->EditCustomAttributes = "";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->EditAttrs["class"] = "form-control";
		$this->pasien_ALAMAT->EditCustomAttributes = "";
		$this->pasien_ALAMAT->EditValue = $this->pasien_ALAMAT->CurrentValue;
		$this->pasien_ALAMAT->PlaceHolder = ew_RemoveHtml($this->pasien_ALAMAT->FldCaption());

		// pasien_KELURAHAN
		$this->pasien_KELURAHAN->EditAttrs["class"] = "form-control";
		$this->pasien_KELURAHAN->EditCustomAttributes = "";
		$this->pasien_KELURAHAN->EditValue = $this->pasien_KELURAHAN->CurrentValue;
		$this->pasien_KELURAHAN->PlaceHolder = ew_RemoveHtml($this->pasien_KELURAHAN->FldCaption());

		// pasien_KDKECAMATAN
		$this->pasien_KDKECAMATAN->EditAttrs["class"] = "form-control";
		$this->pasien_KDKECAMATAN->EditCustomAttributes = "";
		$this->pasien_KDKECAMATAN->EditValue = $this->pasien_KDKECAMATAN->CurrentValue;
		$this->pasien_KDKECAMATAN->PlaceHolder = ew_RemoveHtml($this->pasien_KDKECAMATAN->FldCaption());

		// pasien_KOTA
		$this->pasien_KOTA->EditAttrs["class"] = "form-control";
		$this->pasien_KOTA->EditCustomAttributes = "";
		$this->pasien_KOTA->EditValue = $this->pasien_KOTA->CurrentValue;
		$this->pasien_KOTA->PlaceHolder = ew_RemoveHtml($this->pasien_KOTA->FldCaption());

		// pasien_KDPROVINSI
		$this->pasien_KDPROVINSI->EditAttrs["class"] = "form-control";
		$this->pasien_KDPROVINSI->EditCustomAttributes = "";
		$this->pasien_KDPROVINSI->EditValue = $this->pasien_KDPROVINSI->CurrentValue;
		$this->pasien_KDPROVINSI->PlaceHolder = ew_RemoveHtml($this->pasien_KDPROVINSI->FldCaption());

		// pasien_NOTELP
		$this->pasien_NOTELP->EditAttrs["class"] = "form-control";
		$this->pasien_NOTELP->EditCustomAttributes = "";
		$this->pasien_NOTELP->EditValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->PlaceHolder = ew_RemoveHtml($this->pasien_NOTELP->FldCaption());

		// pasien_NOKTP
		$this->pasien_NOKTP->EditAttrs["class"] = "form-control";
		$this->pasien_NOKTP->EditCustomAttributes = "";
		$this->pasien_NOKTP->EditValue = $this->pasien_NOKTP->CurrentValue;
		$this->pasien_NOKTP->PlaceHolder = ew_RemoveHtml($this->pasien_NOKTP->FldCaption());

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU->EditAttrs["class"] = "form-control";
		$this->pasien_SUAMI_ORTU->EditCustomAttributes = "";
		$this->pasien_SUAMI_ORTU->EditValue = $this->pasien_SUAMI_ORTU->CurrentValue;
		$this->pasien_SUAMI_ORTU->PlaceHolder = ew_RemoveHtml($this->pasien_SUAMI_ORTU->FldCaption());

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->EditAttrs["class"] = "form-control";
		$this->pasien_PEKERJAAN->EditCustomAttributes = "";
		$this->pasien_PEKERJAAN->EditValue = $this->pasien_PEKERJAAN->CurrentValue;
		$this->pasien_PEKERJAAN->PlaceHolder = ew_RemoveHtml($this->pasien_PEKERJAAN->FldCaption());

		// pasien_AGAMA
		$this->pasien_AGAMA->EditAttrs["class"] = "form-control";
		$this->pasien_AGAMA->EditCustomAttributes = "";

		// pasien_PENDIDIKAN
		$this->pasien_PENDIDIKAN->EditAttrs["class"] = "form-control";
		$this->pasien_PENDIDIKAN->EditCustomAttributes = "";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->EditAttrs["class"] = "form-control";
		$this->pasien_ALAMAT_KTP->EditCustomAttributes = "";
		$this->pasien_ALAMAT_KTP->EditValue = $this->pasien_ALAMAT_KTP->CurrentValue;
		$this->pasien_ALAMAT_KTP->PlaceHolder = ew_RemoveHtml($this->pasien_ALAMAT_KTP->FldCaption());

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->EditAttrs["class"] = "form-control";
		$this->pasien_NO_KARTU->EditCustomAttributes = "";
		$this->pasien_NO_KARTU->EditValue = $this->pasien_NO_KARTU->CurrentValue;
		$this->pasien_NO_KARTU->PlaceHolder = ew_RemoveHtml($this->pasien_NO_KARTU->FldCaption());

		// pasien_JNS_PASIEN
		$this->pasien_JNS_PASIEN->EditAttrs["class"] = "form-control";
		$this->pasien_JNS_PASIEN->EditCustomAttributes = "";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->EditAttrs["class"] = "form-control";
		$this->pasien_nama_ayah->EditCustomAttributes = "";
		$this->pasien_nama_ayah->EditValue = $this->pasien_nama_ayah->CurrentValue;
		$this->pasien_nama_ayah->PlaceHolder = ew_RemoveHtml($this->pasien_nama_ayah->FldCaption());

		// pasien_nama_ibu
		$this->pasien_nama_ibu->EditAttrs["class"] = "form-control";
		$this->pasien_nama_ibu->EditCustomAttributes = "";
		$this->pasien_nama_ibu->EditValue = $this->pasien_nama_ibu->CurrentValue;
		$this->pasien_nama_ibu->PlaceHolder = ew_RemoveHtml($this->pasien_nama_ibu->FldCaption());

		// pasien_nama_suami
		$this->pasien_nama_suami->EditAttrs["class"] = "form-control";
		$this->pasien_nama_suami->EditCustomAttributes = "";
		$this->pasien_nama_suami->EditValue = $this->pasien_nama_suami->CurrentValue;
		$this->pasien_nama_suami->PlaceHolder = ew_RemoveHtml($this->pasien_nama_suami->FldCaption());

		// pasien_nama_istri
		$this->pasien_nama_istri->EditAttrs["class"] = "form-control";
		$this->pasien_nama_istri->EditCustomAttributes = "";
		$this->pasien_nama_istri->EditValue = $this->pasien_nama_istri->CurrentValue;
		$this->pasien_nama_istri->PlaceHolder = ew_RemoveHtml($this->pasien_nama_istri->FldCaption());

		// pasien_KD_ETNIS
		$this->pasien_KD_ETNIS->EditAttrs["class"] = "form-control";
		$this->pasien_KD_ETNIS->EditCustomAttributes = "";

		// pasien_KD_BHS_HARIAN
		$this->pasien_KD_BHS_HARIAN->EditAttrs["class"] = "form-control";
		$this->pasien_KD_BHS_HARIAN->EditCustomAttributes = "";

		// BILL_FARMASI_SELESAI
		$this->BILL_FARMASI_SELESAI->EditAttrs["class"] = "form-control";
		$this->BILL_FARMASI_SELESAI->EditCustomAttributes = "";
		$this->BILL_FARMASI_SELESAI->EditValue = $this->BILL_FARMASI_SELESAI->CurrentValue;
		$this->BILL_FARMASI_SELESAI->PlaceHolder = ew_RemoveHtml($this->BILL_FARMASI_SELESAI->FldCaption());

		// TARIF_PELAYANAN_SIMRS
		$this->TARIF_PELAYANAN_SIMRS->EditAttrs["class"] = "form-control";
		$this->TARIF_PELAYANAN_SIMRS->EditCustomAttributes = "";
		$this->TARIF_PELAYANAN_SIMRS->EditValue = $this->TARIF_PELAYANAN_SIMRS->CurrentValue;
		$this->TARIF_PELAYANAN_SIMRS->PlaceHolder = ew_RemoveHtml($this->TARIF_PELAYANAN_SIMRS->FldCaption());
		if (strval($this->TARIF_PELAYANAN_SIMRS->EditValue) <> "" && is_numeric($this->TARIF_PELAYANAN_SIMRS->EditValue)) $this->TARIF_PELAYANAN_SIMRS->EditValue = ew_FormatNumber($this->TARIF_PELAYANAN_SIMRS->EditValue, -2, -1, -2, 0);

		// USER_ADM
		$this->USER_ADM->EditAttrs["class"] = "form-control";
		$this->USER_ADM->EditCustomAttributes = "";
		$this->USER_ADM->EditValue = $this->USER_ADM->CurrentValue;
		$this->USER_ADM->PlaceHolder = ew_RemoveHtml($this->USER_ADM->FldCaption());

		// TARIF_PENUNJANG_NON_MEDIS_IGD
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->EditAttrs["class"] = "form-control";
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->EditCustomAttributes = "";
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->EditValue = $this->TARIF_PENUNJANG_NON_MEDIS_IGD->CurrentValue;
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->PlaceHolder = ew_RemoveHtml($this->TARIF_PENUNJANG_NON_MEDIS_IGD->FldCaption());
		if (strval($this->TARIF_PENUNJANG_NON_MEDIS_IGD->EditValue) <> "" && is_numeric($this->TARIF_PENUNJANG_NON_MEDIS_IGD->EditValue)) $this->TARIF_PENUNJANG_NON_MEDIS_IGD->EditValue = ew_FormatNumber($this->TARIF_PENUNJANG_NON_MEDIS_IGD->EditValue, -2, -1, -2, 0);

		// TARIF_PELAYANAN_DARAH
		$this->TARIF_PELAYANAN_DARAH->EditAttrs["class"] = "form-control";
		$this->TARIF_PELAYANAN_DARAH->EditCustomAttributes = "";
		$this->TARIF_PELAYANAN_DARAH->EditValue = $this->TARIF_PELAYANAN_DARAH->CurrentValue;
		$this->TARIF_PELAYANAN_DARAH->PlaceHolder = ew_RemoveHtml($this->TARIF_PELAYANAN_DARAH->FldCaption());
		if (strval($this->TARIF_PELAYANAN_DARAH->EditValue) <> "" && is_numeric($this->TARIF_PELAYANAN_DARAH->EditValue)) $this->TARIF_PELAYANAN_DARAH->EditValue = ew_FormatNumber($this->TARIF_PELAYANAN_DARAH->EditValue, -2, -1, -2, 0);

		// penjamin_kkl_id
		$this->penjamin_kkl_id->EditAttrs["class"] = "form-control";
		$this->penjamin_kkl_id->EditCustomAttributes = "";
		$this->penjamin_kkl_id->EditValue = $this->penjamin_kkl_id->CurrentValue;
		$this->penjamin_kkl_id->PlaceHolder = ew_RemoveHtml($this->penjamin_kkl_id->FldCaption());

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->EditAttrs["class"] = "form-control";
		$this->asalfaskesrujukan_id->EditCustomAttributes = "";
		$this->asalfaskesrujukan_id->EditValue = $this->asalfaskesrujukan_id->CurrentValue;
		$this->asalfaskesrujukan_id->PlaceHolder = ew_RemoveHtml($this->asalfaskesrujukan_id->FldCaption());

		// peserta_cob
		$this->peserta_cob->EditAttrs["class"] = "form-control";
		$this->peserta_cob->EditCustomAttributes = "";
		$this->peserta_cob->EditValue = $this->peserta_cob->CurrentValue;
		$this->peserta_cob->PlaceHolder = ew_RemoveHtml($this->peserta_cob->FldCaption());

		// poli_eksekutif
		$this->poli_eksekutif->EditAttrs["class"] = "form-control";
		$this->poli_eksekutif->EditCustomAttributes = "";
		$this->poli_eksekutif->EditValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->PlaceHolder = ew_RemoveHtml($this->poli_eksekutif->FldCaption());

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
					if ($this->peserta_cob->Exportable) $Doc->ExportCaption($this->peserta_cob);
					if ($this->poli_eksekutif->Exportable) $Doc->ExportCaption($this->poli_eksekutif);
					if ($this->status_kepesertaan_BPJS->Exportable) $Doc->ExportCaption($this->status_kepesertaan_BPJS);
				} else {
					if ($this->peserta_cob->Exportable) $Doc->ExportCaption($this->peserta_cob);
					if ($this->poli_eksekutif->Exportable) $Doc->ExportCaption($this->poli_eksekutif);
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
						if ($this->peserta_cob->Exportable) $Doc->ExportField($this->peserta_cob);
						if ($this->poli_eksekutif->Exportable) $Doc->ExportField($this->poli_eksekutif);
						if ($this->status_kepesertaan_BPJS->Exportable) $Doc->ExportField($this->status_kepesertaan_BPJS);
					} else {
						if ($this->peserta_cob->Exportable) $Doc->ExportField($this->peserta_cob);
						if ($this->poli_eksekutif->Exportable) $Doc->ExportField($this->poli_eksekutif);
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
		if (preg_match('/^x(\d)*_NOMR$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `KDCARABAYAR` AS FIELD0, `PENANGGUNGJAWAB_NAMA` AS FIELD1, `PENANGGUNGJAWAB_HUBUNGAN` AS FIELD2, `PENANGGUNGJAWAB_ALAMAT` AS FIELD3, `PENANGGUNGJAWAB_PHONE` AS FIELD4, `NO_KARTU` AS FIELD5, `TITLE` AS FIELD6, `NAMA` AS FIELD7, `TEMPAT` AS FIELD8, `TGLLAHIR` AS FIELD9, `JENISKELAMIN` AS FIELD10, `ALAMAT` AS FIELD11, `NOTELP` AS FIELD12, `NOKTP` AS FIELD13, `PEKERJAAN` AS FIELD14, `AGAMA` AS FIELD15, `PENDIDIKAN` AS FIELD16, `ALAMAT_KTP` AS FIELD17, `NO_KARTU` AS FIELD18, `JNS_PASIEN` AS FIELD19, `nama_ayah` AS FIELD20, `nama_ibu` AS FIELD21, `nama_suami` AS FIELD22, `nama_istri` AS FIELD23, `KD_ETNIS` AS FIELD24, `KD_BHS_HARIAN` AS FIELD25 FROM `m_login`";
			$sWhereWrk = "(`NOMR` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->NOMR->LookupFilters = array();
			if (!$GLOBALS["t_pendaftaran"]->UserIDAllow("info")) $sWhereWrk = $GLOBALS["m_login"]->AddUserIDFilter($sWhereWrk);
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->KDCARABAYAR->setDbValue($rs->fields[0]);
					$this->PENANGGUNGJAWAB_NAMA->setDbValue($rs->fields[1]);
					$this->PENANGGUNGJAWAB_HUBUNGAN->setDbValue($rs->fields[2]);
					$this->PENANGGUNGJAWAB_ALAMAT->setDbValue($rs->fields[3]);
					$this->PENANGGUNGJAWAB_PHONE->setDbValue($rs->fields[4]);
					$this->NOKARTU->setDbValue($rs->fields[5]);
					$this->pasien_TITLE->setDbValue($rs->fields[6]);
					$this->pasien_NAMA->setDbValue($rs->fields[7]);
					$this->pasien_TEMPAT->setDbValue($rs->fields[8]);
					$this->pasien_TGLLAHIR->setDbValue($rs->fields[9]);
					$this->pasien_JENISKELAMIN->setDbValue($rs->fields[10]);
					$this->pasien_ALAMAT->setDbValue($rs->fields[11]);
					$this->pasien_NOTELP->setDbValue($rs->fields[12]);
					$this->pasien_NOKTP->setDbValue($rs->fields[13]);
					$this->pasien_PEKERJAAN->setDbValue($rs->fields[14]);
					$this->pasien_AGAMA->setDbValue($rs->fields[15]);
					$this->pasien_PENDIDIKAN->setDbValue($rs->fields[16]);
					$this->pasien_ALAMAT_KTP->setDbValue($rs->fields[17]);
					$this->pasien_NO_KARTU->setDbValue($rs->fields[18]);
					$this->pasien_JNS_PASIEN->setDbValue($rs->fields[19]);
					$this->pasien_nama_ayah->setDbValue($rs->fields[20]);
					$this->pasien_nama_ibu->setDbValue($rs->fields[21]);
					$this->pasien_nama_suami->setDbValue($rs->fields[22]);
					$this->pasien_nama_istri->setDbValue($rs->fields[23]);
					$this->pasien_KD_ETNIS->setDbValue($rs->fields[24]);
					$this->pasien_KD_BHS_HARIAN->setDbValue($rs->fields[25]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = $this->KDCARABAYAR->CurrentValue;
					$ar[] = ($this->PENANGGUNGJAWAB_NAMA->AutoFillOriginalValue) ? $this->PENANGGUNGJAWAB_NAMA->CurrentValue : $this->PENANGGUNGJAWAB_NAMA->EditValue;
					$ar[] = ($this->PENANGGUNGJAWAB_HUBUNGAN->AutoFillOriginalValue) ? $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue : $this->PENANGGUNGJAWAB_HUBUNGAN->EditValue;
					$ar[] = ($this->PENANGGUNGJAWAB_ALAMAT->AutoFillOriginalValue) ? $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue : $this->PENANGGUNGJAWAB_ALAMAT->EditValue;
					$ar[] = ($this->PENANGGUNGJAWAB_PHONE->AutoFillOriginalValue) ? $this->PENANGGUNGJAWAB_PHONE->CurrentValue : $this->PENANGGUNGJAWAB_PHONE->EditValue;
					$ar[] = ($this->NOKARTU->AutoFillOriginalValue) ? $this->NOKARTU->CurrentValue : $this->NOKARTU->EditValue;
					$ar[] = $this->pasien_TITLE->CurrentValue;
					$ar[] = ($this->pasien_NAMA->AutoFillOriginalValue) ? $this->pasien_NAMA->CurrentValue : $this->pasien_NAMA->EditValue;
					$ar[] = ($this->pasien_TEMPAT->AutoFillOriginalValue) ? $this->pasien_TEMPAT->CurrentValue : $this->pasien_TEMPAT->EditValue;
					$ar[] = ($this->pasien_TGLLAHIR->AutoFillOriginalValue) ? $this->pasien_TGLLAHIR->CurrentValue : $this->pasien_TGLLAHIR->EditValue;
					$ar[] = $this->pasien_JENISKELAMIN->CurrentValue;
					$ar[] = ($this->pasien_ALAMAT->AutoFillOriginalValue) ? $this->pasien_ALAMAT->CurrentValue : $this->pasien_ALAMAT->EditValue;
					$ar[] = ($this->pasien_NOTELP->AutoFillOriginalValue) ? $this->pasien_NOTELP->CurrentValue : $this->pasien_NOTELP->EditValue;
					$ar[] = ($this->pasien_NOKTP->AutoFillOriginalValue) ? $this->pasien_NOKTP->CurrentValue : $this->pasien_NOKTP->EditValue;
					$ar[] = ($this->pasien_PEKERJAAN->AutoFillOriginalValue) ? $this->pasien_PEKERJAAN->CurrentValue : $this->pasien_PEKERJAAN->EditValue;
					$ar[] = $this->pasien_AGAMA->CurrentValue;
					$ar[] = $this->pasien_PENDIDIKAN->CurrentValue;
					$ar[] = ($this->pasien_ALAMAT_KTP->AutoFillOriginalValue) ? $this->pasien_ALAMAT_KTP->CurrentValue : $this->pasien_ALAMAT_KTP->EditValue;
					$ar[] = ($this->pasien_NO_KARTU->AutoFillOriginalValue) ? $this->pasien_NO_KARTU->CurrentValue : $this->pasien_NO_KARTU->EditValue;
					$ar[] = $this->pasien_JNS_PASIEN->CurrentValue;
					$ar[] = ($this->pasien_nama_ayah->AutoFillOriginalValue) ? $this->pasien_nama_ayah->CurrentValue : $this->pasien_nama_ayah->EditValue;
					$ar[] = ($this->pasien_nama_ibu->AutoFillOriginalValue) ? $this->pasien_nama_ibu->CurrentValue : $this->pasien_nama_ibu->EditValue;
					$ar[] = ($this->pasien_nama_suami->AutoFillOriginalValue) ? $this->pasien_nama_suami->CurrentValue : $this->pasien_nama_suami->EditValue;
					$ar[] = ($this->pasien_nama_istri->AutoFillOriginalValue) ? $this->pasien_nama_istri->CurrentValue : $this->pasien_nama_istri->EditValue;
					$ar[] = $this->pasien_KD_ETNIS->CurrentValue;
					$ar[] = $this->pasien_KD_BHS_HARIAN->CurrentValue;
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
		$table = 't_pendaftaran';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't_pendaftaran';

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
		$table = 't_pendaftaran';

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
		$table = 't_pendaftaran';

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

		$rsnew["PASIENBARU"] =  ew_ExecuteScalar("select simrs2012.pasien_baru_lama('".$rsnew["NOMR"]."')");
		$status_pasien = $rsnew["PASIENBARU"];
		if($status_pasien==0)
		{
		}elseif($status_pasien==1)
		{
			$newNOMR = ew_ExecuteScalar("select simrs2012.getNewNOMR()");
			$rsnew["NOMR"] = $newNOMR;
		}
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		ew_Execute("call simrs2012.sp_update_data_pasien('".$rsnew["IDXDAFTAR"]."', '".$rsnew["NOMR"]."')");
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

			$no;
		if(isset($_GET["flag"])) {
				$no  = $_GET["flag"];  
		}else{  
				$no = '';
		}
		$this->NOMR->EditValue = $no;
		$this->NIP->ReadOnly = TRUE;
		$this->PASIENBARU->ReadOnly = TRUE;
		$this->NIP->EditValue = CurrentUserName();
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
