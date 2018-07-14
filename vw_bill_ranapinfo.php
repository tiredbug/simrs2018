<?php

// Global variable for table object
$vw_bill_ranap = NULL;

//
// Table class for vw_bill_ranap
//
class cvw_bill_ranap extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id_admission;
	var $nomr;
	var $ket_nama;
	var $parent_nomr;
	var $dokterpengirim;
	var $statusbayar;
	var $kirimdari;
	var $keluargadekat;
	var $panggungjawab;
	var $masukrs;
	var $noruang;
	var $tempat_tidur_id;
	var $keluarrs;
	var $icd_masuk;
	var $icd_keluar;
	var $NIP;
	var $kd_rujuk;
	var $st_bayar;
	var $dokter_penanggungjawab;
	var $perawat;
	var $KELASPERAWATAN_ID;
	var $NO_SKP;
	var $ket_tgllahir;
	var $ket_alamat;
	var $ket_jeniskelamin;
	var $ket_title;
	var $grup_ruang_id;
	var $nott;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_bill_ranap';
		$this->TableName = 'vw_bill_ranap';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_bill_ranap`";
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
		$this->ShowMultipleDetails = TRUE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id_admission
		$this->id_admission = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_id_admission', 'id_admission', '`id_admission`', '`id_admission`', 3, -1, FALSE, '`id_admission`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_admission->Sortable = TRUE; // Allow sort
		$this->id_admission->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_admission'] = &$this->id_admission;

		// nomr
		$this->nomr = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_nomr', 'nomr', '`nomr`', '`nomr`', 200, -1, FALSE, '`nomr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomr->Sortable = TRUE; // Allow sort
		$this->fields['nomr'] = &$this->nomr;

		// ket_nama
		$this->ket_nama = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_ket_nama', 'ket_nama', '`ket_nama`', '`ket_nama`', 200, -1, FALSE, '`ket_nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_nama->Sortable = TRUE; // Allow sort
		$this->fields['ket_nama'] = &$this->ket_nama;

		// parent_nomr
		$this->parent_nomr = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_parent_nomr', 'parent_nomr', '`parent_nomr`', '`parent_nomr`', 200, -1, FALSE, '`parent_nomr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->parent_nomr->Sortable = TRUE; // Allow sort
		$this->fields['parent_nomr'] = &$this->parent_nomr;

		// dokterpengirim
		$this->dokterpengirim = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_dokterpengirim', 'dokterpengirim', '`dokterpengirim`', '`dokterpengirim`', 3, -1, FALSE, '`dokterpengirim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->dokterpengirim->Sortable = TRUE; // Allow sort
		$this->dokterpengirim->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->dokterpengirim->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->dokterpengirim->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dokterpengirim'] = &$this->dokterpengirim;

		// statusbayar
		$this->statusbayar = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_statusbayar', 'statusbayar', '`statusbayar`', '`statusbayar`', 3, -1, FALSE, '`statusbayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->statusbayar->Sortable = TRUE; // Allow sort
		$this->statusbayar->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->statusbayar->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->statusbayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['statusbayar'] = &$this->statusbayar;

		// kirimdari
		$this->kirimdari = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_kirimdari', 'kirimdari', '`kirimdari`', '`kirimdari`', 3, -1, FALSE, '`kirimdari`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kirimdari->Sortable = TRUE; // Allow sort
		$this->kirimdari->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kirimdari->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->kirimdari->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kirimdari'] = &$this->kirimdari;

		// keluargadekat
		$this->keluargadekat = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_keluargadekat', 'keluargadekat', '`keluargadekat`', '`keluargadekat`', 200, -1, FALSE, '`keluargadekat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keluargadekat->Sortable = TRUE; // Allow sort
		$this->fields['keluargadekat'] = &$this->keluargadekat;

		// panggungjawab
		$this->panggungjawab = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_panggungjawab', 'panggungjawab', '`panggungjawab`', '`panggungjawab`', 200, -1, FALSE, '`panggungjawab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->panggungjawab->Sortable = TRUE; // Allow sort
		$this->fields['panggungjawab'] = &$this->panggungjawab;

		// masukrs
		$this->masukrs = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_masukrs', 'masukrs', '`masukrs`', ew_CastDateFieldForLike('`masukrs`', 11, "DB"), 135, 11, FALSE, '`masukrs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->masukrs->Sortable = TRUE; // Allow sort
		$this->masukrs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['masukrs'] = &$this->masukrs;

		// noruang
		$this->noruang = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_noruang', 'noruang', '`noruang`', '`noruang`', 3, -1, FALSE, '`noruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->noruang->Sortable = TRUE; // Allow sort
		$this->noruang->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->noruang->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->noruang->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['noruang'] = &$this->noruang;

		// tempat_tidur_id
		$this->tempat_tidur_id = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_tempat_tidur_id', 'tempat_tidur_id', '`tempat_tidur_id`', '`tempat_tidur_id`', 3, -1, FALSE, '`tempat_tidur_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->tempat_tidur_id->Sortable = TRUE; // Allow sort
		$this->tempat_tidur_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->tempat_tidur_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->tempat_tidur_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tempat_tidur_id'] = &$this->tempat_tidur_id;

		// keluarrs
		$this->keluarrs = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_keluarrs', 'keluarrs', '`keluarrs`', ew_CastDateFieldForLike('`keluarrs`', 0, "DB"), 135, 0, FALSE, '`keluarrs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keluarrs->Sortable = TRUE; // Allow sort
		$this->keluarrs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['keluarrs'] = &$this->keluarrs;

		// icd_masuk
		$this->icd_masuk = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_icd_masuk', 'icd_masuk', '`icd_masuk`', '`icd_masuk`', 200, -1, FALSE, '`icd_masuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->icd_masuk->Sortable = TRUE; // Allow sort
		$this->fields['icd_masuk'] = &$this->icd_masuk;

		// icd_keluar
		$this->icd_keluar = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_icd_keluar', 'icd_keluar', '`icd_keluar`', '`icd_keluar`', 200, -1, FALSE, '`icd_keluar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->icd_keluar->Sortable = TRUE; // Allow sort
		$this->fields['icd_keluar'] = &$this->icd_keluar;

		// NIP
		$this->NIP = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_NIP', 'NIP', '`NIP`', '`NIP`', 200, -1, FALSE, '`NIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIP->Sortable = TRUE; // Allow sort
		$this->fields['NIP'] = &$this->NIP;

		// kd_rujuk
		$this->kd_rujuk = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_kd_rujuk', 'kd_rujuk', '`kd_rujuk`', '`kd_rujuk`', 3, -1, FALSE, '`kd_rujuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kd_rujuk->Sortable = TRUE; // Allow sort
		$this->kd_rujuk->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kd_rujuk->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->kd_rujuk->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kd_rujuk'] = &$this->kd_rujuk;

		// st_bayar
		$this->st_bayar = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_st_bayar', 'st_bayar', '`st_bayar`', '`st_bayar`', 3, -1, FALSE, '`st_bayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->st_bayar->Sortable = TRUE; // Allow sort
		$this->st_bayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['st_bayar'] = &$this->st_bayar;

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_dokter_penanggungjawab', 'dokter_penanggungjawab', '`dokter_penanggungjawab`', '`dokter_penanggungjawab`', 3, -1, FALSE, '`dokter_penanggungjawab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->dokter_penanggungjawab->Sortable = TRUE; // Allow sort
		$this->dokter_penanggungjawab->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->dokter_penanggungjawab->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->dokter_penanggungjawab->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dokter_penanggungjawab'] = &$this->dokter_penanggungjawab;

		// perawat
		$this->perawat = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_perawat', 'perawat', '`perawat`', '`perawat`', 3, -1, FALSE, '`perawat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->perawat->Sortable = TRUE; // Allow sort
		$this->perawat->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['perawat'] = &$this->perawat;

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_KELASPERAWATAN_ID', 'KELASPERAWATAN_ID', '`KELASPERAWATAN_ID`', '`KELASPERAWATAN_ID`', 3, -1, FALSE, '`KELASPERAWATAN_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KELASPERAWATAN_ID->Sortable = TRUE; // Allow sort
		$this->KELASPERAWATAN_ID->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KELASPERAWATAN_ID->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KELASPERAWATAN_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KELASPERAWATAN_ID'] = &$this->KELASPERAWATAN_ID;

		// NO_SKP
		$this->NO_SKP = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_NO_SKP', 'NO_SKP', '`NO_SKP`', '`NO_SKP`', 200, -1, FALSE, '`NO_SKP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_SKP->Sortable = TRUE; // Allow sort
		$this->fields['NO_SKP'] = &$this->NO_SKP;

		// ket_tgllahir
		$this->ket_tgllahir = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_ket_tgllahir', 'ket_tgllahir', '`ket_tgllahir`', ew_CastDateFieldForLike('`ket_tgllahir`', 0, "DB"), 135, 0, FALSE, '`ket_tgllahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_tgllahir->Sortable = TRUE; // Allow sort
		$this->ket_tgllahir->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['ket_tgllahir'] = &$this->ket_tgllahir;

		// ket_alamat
		$this->ket_alamat = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_ket_alamat', 'ket_alamat', '`ket_alamat`', '`ket_alamat`', 200, -1, FALSE, '`ket_alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_alamat->Sortable = TRUE; // Allow sort
		$this->fields['ket_alamat'] = &$this->ket_alamat;

		// ket_jeniskelamin
		$this->ket_jeniskelamin = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_ket_jeniskelamin', 'ket_jeniskelamin', '`ket_jeniskelamin`', '`ket_jeniskelamin`', 200, -1, FALSE, '`ket_jeniskelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_jeniskelamin->Sortable = TRUE; // Allow sort
		$this->fields['ket_jeniskelamin'] = &$this->ket_jeniskelamin;

		// ket_title
		$this->ket_title = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_ket_title', 'ket_title', '`ket_title`', '`ket_title`', 200, -1, FALSE, '`ket_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_title->Sortable = TRUE; // Allow sort
		$this->fields['ket_title'] = &$this->ket_title;

		// grup_ruang_id
		$this->grup_ruang_id = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_grup_ruang_id', 'grup_ruang_id', '`grup_ruang_id`', '`grup_ruang_id`', 3, -1, FALSE, '`grup_ruang_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grup_ruang_id->Sortable = TRUE; // Allow sort
		$this->grup_ruang_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['grup_ruang_id'] = &$this->grup_ruang_id;

		// nott
		$this->nott = new cField('vw_bill_ranap', 'vw_bill_ranap', 'x_nott', 'nott', '`nott`', '`nott`', 200, -1, FALSE, '`nott`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nott->Sortable = TRUE; // Allow sort
		$this->fields['nott'] = &$this->nott;
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
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_visitekonsul_dokter") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
			$sDetailUrl .= "&fk_noruang=" . urlencode($this->noruang->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_konsul_dokter") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
			$sDetailUrl .= "&fk_noruang=" . urlencode($this->noruang->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_tmno") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_tmno"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
			$sDetailUrl .= "&fk_noruang=" . urlencode($this->noruang->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_tindakan_perawat") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
			$sDetailUrl .= "&fk_noruang=" . urlencode($this->noruang->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_visite_gizi") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_visite_gizi"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
			$sDetailUrl .= "&fk_noruang=" . urlencode($this->noruang->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_visite_farmasi") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
			$sDetailUrl .= "&fk_noruang=" . urlencode($this->noruang->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_tindakan_penunjang") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_konsul_vct") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_konsul_vct"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_pelayanan_los") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_tindakan_lain") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_bill_ranap_detail_tindakan_kebidanan") {
			$sDetailUrl = $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$sDetailUrl .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$sDetailUrl .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$sDetailUrl .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->KELASPERAWATAN_ID->CurrentValue);
			$sDetailUrl .= "&fk_noruang=" . urlencode($this->noruang->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "vw_bill_ranaplist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_bill_ranap`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`id_admission` DESC";
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
			return "vw_bill_ranaplist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_bill_ranaplist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_bill_ranapview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_bill_ranapview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_bill_ranapadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_bill_ranapadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_bill_ranapedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_bill_ranapedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("vw_bill_ranapadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_bill_ranapadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_bill_ranapdelete.php", $this->UrlParm());
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
		$this->parent_nomr->setDbValue($rs->fields('parent_nomr'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->icd_masuk->setDbValue($rs->fields('icd_masuk'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->kd_rujuk->setDbValue($rs->fields('kd_rujuk'));
		$this->st_bayar->setDbValue($rs->fields('st_bayar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->perawat->setDbValue($rs->fields('perawat'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->ket_tgllahir->setDbValue($rs->fields('ket_tgllahir'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->grup_ruang_id->setDbValue($rs->fields('grup_ruang_id'));
		$this->nott->setDbValue($rs->fields('nott'));
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
		// parent_nomr
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// keluarrs
		// icd_masuk
		// icd_keluar
		// NIP
		// kd_rujuk
		// st_bayar
		// dokter_penanggungjawab
		// perawat
		// KELASPERAWATAN_ID
		// NO_SKP
		// ket_tgllahir
		// ket_alamat
		// ket_jeniskelamin
		// ket_title
		// grup_ruang_id
		// nott
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
		$lookuptblfilter = "`CBG_USE_IND`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

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

		// grup_ruang_id
		$this->grup_ruang_id->ViewValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->ViewCustomAttributes = "";

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

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

		// NO_SKP
		$this->NO_SKP->LinkCustomAttributes = "";
		$this->NO_SKP->HrefValue = "";
		$this->NO_SKP->TooltipValue = "";

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

		// grup_ruang_id
		$this->grup_ruang_id->LinkCustomAttributes = "";
		$this->grup_ruang_id->HrefValue = "";
		$this->grup_ruang_id->TooltipValue = "";

		// nott
		$this->nott->LinkCustomAttributes = "";
		$this->nott->HrefValue = "";
		$this->nott->TooltipValue = "";

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
				$this->nomr->EditValue = $this->nomr->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nomr->EditValue = $this->nomr->CurrentValue;
			}
		} else {
			$this->nomr->EditValue = NULL;
		}
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->EditAttrs["class"] = "form-control";
		$this->ket_nama->EditCustomAttributes = "";
		$this->ket_nama->EditValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->PlaceHolder = ew_RemoveHtml($this->ket_nama->FldCaption());

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
				$this->statusbayar->EditValue = $this->statusbayar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statusbayar->EditValue = $this->statusbayar->CurrentValue;
			}
		} else {
			$this->statusbayar->EditValue = NULL;
		}
		$this->statusbayar->ViewCustomAttributes = "";

		// kirimdari
		$this->kirimdari->EditAttrs["class"] = "form-control";
		$this->kirimdari->EditCustomAttributes = "";
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
				$this->kirimdari->EditValue = $this->kirimdari->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kirimdari->EditValue = $this->kirimdari->CurrentValue;
			}
		} else {
			$this->kirimdari->EditValue = NULL;
		}
		$this->kirimdari->ViewCustomAttributes = "";

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
		$this->masukrs->EditValue = $this->masukrs->CurrentValue;
		$this->masukrs->EditValue = ew_FormatDateTime($this->masukrs->EditValue, 11);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		$this->noruang->EditAttrs["class"] = "form-control";
		$this->noruang->EditCustomAttributes = "";

		// tempat_tidur_id
		$this->tempat_tidur_id->EditAttrs["class"] = "form-control";
		$this->tempat_tidur_id->EditCustomAttributes = "";

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

		// NO_SKP
		$this->NO_SKP->EditAttrs["class"] = "form-control";
		$this->NO_SKP->EditCustomAttributes = "";
		$this->NO_SKP->EditValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->PlaceHolder = ew_RemoveHtml($this->NO_SKP->FldCaption());

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

		// grup_ruang_id
		$this->grup_ruang_id->EditAttrs["class"] = "form-control";
		$this->grup_ruang_id->EditCustomAttributes = "";
		$this->grup_ruang_id->EditValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->PlaceHolder = ew_RemoveHtml($this->grup_ruang_id->FldCaption());

		// nott
		$this->nott->EditAttrs["class"] = "form-control";
		$this->nott->EditCustomAttributes = "";
		$this->nott->EditValue = $this->nott->CurrentValue;
		$this->nott->PlaceHolder = ew_RemoveHtml($this->nott->FldCaption());

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
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->masukrs->Exportable) $Doc->ExportCaption($this->masukrs);
					if ($this->tempat_tidur_id->Exportable) $Doc->ExportCaption($this->tempat_tidur_id);
					if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportCaption($this->KELASPERAWATAN_ID);
					if ($this->NO_SKP->Exportable) $Doc->ExportCaption($this->NO_SKP);
					if ($this->nott->Exportable) $Doc->ExportCaption($this->nott);
				} else {
					if ($this->id_admission->Exportable) $Doc->ExportCaption($this->id_admission);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->ket_nama->Exportable) $Doc->ExportCaption($this->ket_nama);
					if ($this->parent_nomr->Exportable) $Doc->ExportCaption($this->parent_nomr);
					if ($this->dokterpengirim->Exportable) $Doc->ExportCaption($this->dokterpengirim);
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->kirimdari->Exportable) $Doc->ExportCaption($this->kirimdari);
					if ($this->keluargadekat->Exportable) $Doc->ExportCaption($this->keluargadekat);
					if ($this->panggungjawab->Exportable) $Doc->ExportCaption($this->panggungjawab);
					if ($this->masukrs->Exportable) $Doc->ExportCaption($this->masukrs);
					if ($this->noruang->Exportable) $Doc->ExportCaption($this->noruang);
					if ($this->tempat_tidur_id->Exportable) $Doc->ExportCaption($this->tempat_tidur_id);
					if ($this->keluarrs->Exportable) $Doc->ExportCaption($this->keluarrs);
					if ($this->icd_masuk->Exportable) $Doc->ExportCaption($this->icd_masuk);
					if ($this->icd_keluar->Exportable) $Doc->ExportCaption($this->icd_keluar);
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->kd_rujuk->Exportable) $Doc->ExportCaption($this->kd_rujuk);
					if ($this->st_bayar->Exportable) $Doc->ExportCaption($this->st_bayar);
					if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportCaption($this->dokter_penanggungjawab);
					if ($this->perawat->Exportable) $Doc->ExportCaption($this->perawat);
					if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportCaption($this->KELASPERAWATAN_ID);
					if ($this->NO_SKP->Exportable) $Doc->ExportCaption($this->NO_SKP);
					if ($this->ket_tgllahir->Exportable) $Doc->ExportCaption($this->ket_tgllahir);
					if ($this->ket_alamat->Exportable) $Doc->ExportCaption($this->ket_alamat);
					if ($this->ket_jeniskelamin->Exportable) $Doc->ExportCaption($this->ket_jeniskelamin);
					if ($this->ket_title->Exportable) $Doc->ExportCaption($this->ket_title);
					if ($this->grup_ruang_id->Exportable) $Doc->ExportCaption($this->grup_ruang_id);
					if ($this->nott->Exportable) $Doc->ExportCaption($this->nott);
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
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->masukrs->Exportable) $Doc->ExportField($this->masukrs);
						if ($this->tempat_tidur_id->Exportable) $Doc->ExportField($this->tempat_tidur_id);
						if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportField($this->KELASPERAWATAN_ID);
						if ($this->NO_SKP->Exportable) $Doc->ExportField($this->NO_SKP);
						if ($this->nott->Exportable) $Doc->ExportField($this->nott);
					} else {
						if ($this->id_admission->Exportable) $Doc->ExportField($this->id_admission);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->ket_nama->Exportable) $Doc->ExportField($this->ket_nama);
						if ($this->parent_nomr->Exportable) $Doc->ExportField($this->parent_nomr);
						if ($this->dokterpengirim->Exportable) $Doc->ExportField($this->dokterpengirim);
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->kirimdari->Exportable) $Doc->ExportField($this->kirimdari);
						if ($this->keluargadekat->Exportable) $Doc->ExportField($this->keluargadekat);
						if ($this->panggungjawab->Exportable) $Doc->ExportField($this->panggungjawab);
						if ($this->masukrs->Exportable) $Doc->ExportField($this->masukrs);
						if ($this->noruang->Exportable) $Doc->ExportField($this->noruang);
						if ($this->tempat_tidur_id->Exportable) $Doc->ExportField($this->tempat_tidur_id);
						if ($this->keluarrs->Exportable) $Doc->ExportField($this->keluarrs);
						if ($this->icd_masuk->Exportable) $Doc->ExportField($this->icd_masuk);
						if ($this->icd_keluar->Exportable) $Doc->ExportField($this->icd_keluar);
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->kd_rujuk->Exportable) $Doc->ExportField($this->kd_rujuk);
						if ($this->st_bayar->Exportable) $Doc->ExportField($this->st_bayar);
						if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportField($this->dokter_penanggungjawab);
						if ($this->perawat->Exportable) $Doc->ExportField($this->perawat);
						if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportField($this->KELASPERAWATAN_ID);
						if ($this->NO_SKP->Exportable) $Doc->ExportField($this->NO_SKP);
						if ($this->ket_tgllahir->Exportable) $Doc->ExportField($this->ket_tgllahir);
						if ($this->ket_alamat->Exportable) $Doc->ExportField($this->ket_alamat);
						if ($this->ket_jeniskelamin->Exportable) $Doc->ExportField($this->ket_jeniskelamin);
						if ($this->ket_title->Exportable) $Doc->ExportField($this->ket_title);
						if ($this->grup_ruang_id->Exportable) $Doc->ExportField($this->grup_ruang_id);
						if ($this->nott->Exportable) $Doc->ExportField($this->nott);
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
		$table = 'vw_bill_ranap';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'vw_bill_ranap';

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
		$table = 'vw_bill_ranap';

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
		$table = 'vw_bill_ranap';

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
		//$r = Security()->CurrentUserLevelID();
		//if($r==4)
	//	{

			ew_AddFilter($filter, "ISNULL(keluarrs)OR (keluarrs = 'NULL')");

		//}
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

		if (CurrentPageID() == "add" && $this->CurrentAction != "F") {
			if(isset($_GET["IDXDAFTAR"])) {
				$this->id_admission->ReadOnly = TRUE;
				$this->nomr->ReadOnly = TRUE;
				$data_order_admision =  ew_ExecuteRow("select * from t_orderadmission where IDXDAFTAR = '".$_GET["IDXDAFTAR"]."' LIMIT 1");
				$data_pendaftaran = ew_ExecuteRow("SELECT * FROM simrs2012.t_pendaftaran where IDXDAFTAR = '".$data_order_admision["IDXDAFTAR"]."' LIMIT 1");
				$data_pasien = ew_ExecuteRow("SELECT NOMR,TITLE,NAMA,ALAMAT,JENISKELAMIN,TGLLAHIR FROM simrs2012.m_pasien WHERE NOMR = '".$data_order_admision["NOMR"]."' LIMIT 1");
	$this->ket_nama->EditValue = $data_pasien["NAMA"];
		$this->ket_nama->ReadOnly = TRUE;
	$this->ket_tgllahir->EditValue = $data_pasien["TGLLAHIR"];
		$this->ket_tgllahir->ReadOnly = TRUE;
	$this->ket_alamat->EditValue = $data_pasien["ALAMAT"];
		$this->ket_alamat->ReadOnly = TRUE;
	$this->ket_jeniskelamin->EditValue = $data_pasien["JENISKELAMIN"];
		$this->ket_jeniskelamin->ReadOnly = TRUE;
	$this->ket_title->EditValue = $data_pasien["TITLE"];
		$this->ket_title->ReadOnly = TRUE;
				$this->id_admission->EditValue =$_GET["IDXDAFTAR"];
				$this->nomr->EditValue = $data_order_admision["NOMR"];
				$this->panggungjawab->EditValue = $data_pendaftaran["PENANGGUNGJAWAB_NAMA"];
				$this->keluargadekat->EditValue = $data_pendaftaran["PENANGGUNGJAWAB_NAMA"];
				$this->NIP->EditValue = CurrentUserName();
					$this->NIP->ReadOnly = TRUE;
					$this->nott->ReadOnly = TRUE;
			} else {
			}
		}

		// Kondisi saat form Tambah sedang dalam mode konfirmasi
		if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
