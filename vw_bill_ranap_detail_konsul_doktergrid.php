<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($vw_bill_ranap_detail_konsul_dokter_grid)) $vw_bill_ranap_detail_konsul_dokter_grid = new cvw_bill_ranap_detail_konsul_dokter_grid();

// Page init
$vw_bill_ranap_detail_konsul_dokter_grid->Page_Init();

// Page main
$vw_bill_ranap_detail_konsul_dokter_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_detail_konsul_dokter_grid->Page_Render();
?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->Export == "") { ?>
<script type="text/javascript">

// Form object
var fvw_bill_ranap_detail_konsul_doktergrid = new ew_Form("fvw_bill_ranap_detail_konsul_doktergrid", "grid");
fvw_bill_ranap_detail_konsul_doktergrid.FormKeyCountName = '<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->FormKeyCountName ?>';

// Validate form
fvw_bill_ranap_detail_konsul_doktergrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_konsul_dokter->tanggal->FldCaption(), $vw_bill_ranap_detail_konsul_dokter->tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_konsul_dokter->tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kode_tindakan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->FldCaption(), $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kode_dokter");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_konsul_dokter->kode_dokter->FldCaption(), $vw_bill_ranap_detail_konsul_dokter->kode_dokter->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_konsul_dokter->qty->FldCaption(), $vw_bill_ranap_detail_konsul_dokter->qty->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_konsul_dokter->qty->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_konsul_dokter->tarif->FldCaption(), $vw_bill_ranap_detail_konsul_dokter->tarif->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_konsul_dokter->tarif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_no_ruang");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_konsul_dokter->no_ruang->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fvw_bill_ranap_detail_konsul_doktergrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "tanggal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kode_tindakan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kode_dokter", false)) return false;
	if (ew_ValueChanged(fobj, infix, "qty", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tarif", false)) return false;
	if (ew_ValueChanged(fobj, infix, "user", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_ruang", false)) return false;
	return true;
}

// Form_CustomValidate event
fvw_bill_ranap_detail_konsul_doktergrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranap_detail_konsul_doktergrid.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranap_detail_konsul_doktergrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranap_detail_konsul_doktergrid.Lists["x_kode_tindakan"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama_tindakan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_bill_ranap_data_tarif_tindakan"};
fvw_bill_ranap_detail_konsul_doktergrid.Lists["x_kode_dokter"] = {"LinkField":"x_kd_dokter","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_dokter_jaga_ranap"};

// Form object for search
</script>
<?php } ?>
<?php
if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridadd") {
	if ($vw_bill_ranap_detail_konsul_dokter->CurrentMode == "copy") {
		$bSelectLimit = $vw_bill_ranap_detail_konsul_dokter_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs = $vw_bill_ranap_detail_konsul_dokter->SelectRecordCount();
			$vw_bill_ranap_detail_konsul_dokter_grid->Recordset = $vw_bill_ranap_detail_konsul_dokter_grid->LoadRecordset($vw_bill_ranap_detail_konsul_dokter_grid->StartRec-1, $vw_bill_ranap_detail_konsul_dokter_grid->DisplayRecs);
		} else {
			if ($vw_bill_ranap_detail_konsul_dokter_grid->Recordset = $vw_bill_ranap_detail_konsul_dokter_grid->LoadRecordset())
				$vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs = $vw_bill_ranap_detail_konsul_dokter_grid->Recordset->RecordCount();
		}
		$vw_bill_ranap_detail_konsul_dokter_grid->StartRec = 1;
		$vw_bill_ranap_detail_konsul_dokter_grid->DisplayRecs = $vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs;
	} else {
		$vw_bill_ranap_detail_konsul_dokter->CurrentFilter = "0=1";
		$vw_bill_ranap_detail_konsul_dokter_grid->StartRec = 1;
		$vw_bill_ranap_detail_konsul_dokter_grid->DisplayRecs = $vw_bill_ranap_detail_konsul_dokter->GridAddRowCount;
	}
	$vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs = $vw_bill_ranap_detail_konsul_dokter_grid->DisplayRecs;
	$vw_bill_ranap_detail_konsul_dokter_grid->StopRec = $vw_bill_ranap_detail_konsul_dokter_grid->DisplayRecs;
} else {
	$bSelectLimit = $vw_bill_ranap_detail_konsul_dokter_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs <= 0)
			$vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs = $vw_bill_ranap_detail_konsul_dokter->SelectRecordCount();
	} else {
		if (!$vw_bill_ranap_detail_konsul_dokter_grid->Recordset && ($vw_bill_ranap_detail_konsul_dokter_grid->Recordset = $vw_bill_ranap_detail_konsul_dokter_grid->LoadRecordset()))
			$vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs = $vw_bill_ranap_detail_konsul_dokter_grid->Recordset->RecordCount();
	}
	$vw_bill_ranap_detail_konsul_dokter_grid->StartRec = 1;
	$vw_bill_ranap_detail_konsul_dokter_grid->DisplayRecs = $vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$vw_bill_ranap_detail_konsul_dokter_grid->Recordset = $vw_bill_ranap_detail_konsul_dokter_grid->LoadRecordset($vw_bill_ranap_detail_konsul_dokter_grid->StartRec-1, $vw_bill_ranap_detail_konsul_dokter_grid->DisplayRecs);

	// Set no record found message
	if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "" && $vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_bill_ranap_detail_konsul_dokter_grid->setWarningMessage(ew_DeniedMsg());
		if ($vw_bill_ranap_detail_konsul_dokter_grid->SearchWhere == "0=101")
			$vw_bill_ranap_detail_konsul_dokter_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_bill_ranap_detail_konsul_dokter_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$vw_bill_ranap_detail_konsul_dokter_grid->RenderOtherOptions();
?>
<?php $vw_bill_ranap_detail_konsul_dokter_grid->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_detail_konsul_dokter_grid->ShowMessage();
?>
<?php if ($vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs > 0 || $vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_bill_ranap_detail_konsul_dokter">
<div id="fvw_bill_ranap_detail_konsul_doktergrid" class="ewForm form-inline">
<div id="gmp_vw_bill_ranap_detail_konsul_dokter" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_vw_bill_ranap_detail_konsul_doktergrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bill_ranap_detail_konsul_dokter->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_bill_ranap_detail_konsul_dokter_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_bill_ranap_detail_konsul_dokter_grid->RenderListOptions();

// Render list options (header, left)
$vw_bill_ranap_detail_konsul_dokter_grid->ListOptions->Render("header", "left");
?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->tanggal->Visible) { // tanggal ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->SortUrl($vw_bill_ranap_detail_konsul_dokter->tanggal) == "") { ?>
		<th data-name="tanggal"><div id="elh_vw_bill_ranap_detail_konsul_dokter_tanggal" class="vw_bill_ranap_detail_konsul_dokter_tanggal"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tanggal"><div><div id="elh_vw_bill_ranap_detail_konsul_dokter_tanggal" class="vw_bill_ranap_detail_konsul_dokter_tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_konsul_dokter->tanggal->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_konsul_dokter->tanggal->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->Visible) { // kode_tindakan ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->SortUrl($vw_bill_ranap_detail_konsul_dokter->kode_tindakan) == "") { ?>
		<th data-name="kode_tindakan"><div id="elh_vw_bill_ranap_detail_konsul_dokter_kode_tindakan" class="vw_bill_ranap_detail_konsul_dokter_kode_tindakan"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_tindakan"><div><div id="elh_vw_bill_ranap_detail_konsul_dokter_kode_tindakan" class="vw_bill_ranap_detail_konsul_dokter_kode_tindakan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_konsul_dokter->kode_dokter->Visible) { // kode_dokter ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->SortUrl($vw_bill_ranap_detail_konsul_dokter->kode_dokter) == "") { ?>
		<th data-name="kode_dokter"><div id="elh_vw_bill_ranap_detail_konsul_dokter_kode_dokter" class="vw_bill_ranap_detail_konsul_dokter_kode_dokter"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_dokter"><div><div id="elh_vw_bill_ranap_detail_konsul_dokter_kode_dokter" class="vw_bill_ranap_detail_konsul_dokter_kode_dokter">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_konsul_dokter->kode_dokter->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_konsul_dokter->kode_dokter->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_konsul_dokter->qty->Visible) { // qty ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->SortUrl($vw_bill_ranap_detail_konsul_dokter->qty) == "") { ?>
		<th data-name="qty"><div id="elh_vw_bill_ranap_detail_konsul_dokter_qty" class="vw_bill_ranap_detail_konsul_dokter_qty"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->qty->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="qty"><div><div id="elh_vw_bill_ranap_detail_konsul_dokter_qty" class="vw_bill_ranap_detail_konsul_dokter_qty">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->qty->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_konsul_dokter->qty->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_konsul_dokter->qty->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_konsul_dokter->tarif->Visible) { // tarif ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->SortUrl($vw_bill_ranap_detail_konsul_dokter->tarif) == "") { ?>
		<th data-name="tarif"><div id="elh_vw_bill_ranap_detail_konsul_dokter_tarif" class="vw_bill_ranap_detail_konsul_dokter_tarif"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tarif"><div><div id="elh_vw_bill_ranap_detail_konsul_dokter_tarif" class="vw_bill_ranap_detail_konsul_dokter_tarif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_konsul_dokter->tarif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_konsul_dokter->tarif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_konsul_dokter->user->Visible) { // user ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->SortUrl($vw_bill_ranap_detail_konsul_dokter->user) == "") { ?>
		<th data-name="user"><div id="elh_vw_bill_ranap_detail_konsul_dokter_user" class="vw_bill_ranap_detail_konsul_dokter_user"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->user->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user"><div><div id="elh_vw_bill_ranap_detail_konsul_dokter_user" class="vw_bill_ranap_detail_konsul_dokter_user">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->user->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_konsul_dokter->user->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_konsul_dokter->user->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_konsul_dokter->no_ruang->Visible) { // no_ruang ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->SortUrl($vw_bill_ranap_detail_konsul_dokter->no_ruang) == "") { ?>
		<th data-name="no_ruang"><div id="elh_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="vw_bill_ranap_detail_konsul_dokter_no_ruang"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_ruang"><div><div id="elh_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="vw_bill_ranap_detail_konsul_dokter_no_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_konsul_dokter->no_ruang->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_konsul_dokter->no_ruang->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_bill_ranap_detail_konsul_dokter_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$vw_bill_ranap_detail_konsul_dokter_grid->StartRec = 1;
$vw_bill_ranap_detail_konsul_dokter_grid->StopRec = $vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($vw_bill_ranap_detail_konsul_dokter_grid->FormKeyCountName) && ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridadd" || $vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridedit" || $vw_bill_ranap_detail_konsul_dokter->CurrentAction == "F")) {
		$vw_bill_ranap_detail_konsul_dokter_grid->KeyCount = $objForm->GetValue($vw_bill_ranap_detail_konsul_dokter_grid->FormKeyCountName);
		$vw_bill_ranap_detail_konsul_dokter_grid->StopRec = $vw_bill_ranap_detail_konsul_dokter_grid->StartRec + $vw_bill_ranap_detail_konsul_dokter_grid->KeyCount - 1;
	}
}
$vw_bill_ranap_detail_konsul_dokter_grid->RecCnt = $vw_bill_ranap_detail_konsul_dokter_grid->StartRec - 1;
if ($vw_bill_ranap_detail_konsul_dokter_grid->Recordset && !$vw_bill_ranap_detail_konsul_dokter_grid->Recordset->EOF) {
	$vw_bill_ranap_detail_konsul_dokter_grid->Recordset->MoveFirst();
	$bSelectLimit = $vw_bill_ranap_detail_konsul_dokter_grid->UseSelectLimit;
	if (!$bSelectLimit && $vw_bill_ranap_detail_konsul_dokter_grid->StartRec > 1)
		$vw_bill_ranap_detail_konsul_dokter_grid->Recordset->Move($vw_bill_ranap_detail_konsul_dokter_grid->StartRec - 1);
} elseif (!$vw_bill_ranap_detail_konsul_dokter->AllowAddDeleteRow && $vw_bill_ranap_detail_konsul_dokter_grid->StopRec == 0) {
	$vw_bill_ranap_detail_konsul_dokter_grid->StopRec = $vw_bill_ranap_detail_konsul_dokter->GridAddRowCount;
}

// Initialize aggregate
$vw_bill_ranap_detail_konsul_dokter->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_bill_ranap_detail_konsul_dokter->ResetAttrs();
$vw_bill_ranap_detail_konsul_dokter_grid->RenderRow();
if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridadd")
	$vw_bill_ranap_detail_konsul_dokter_grid->RowIndex = 0;
if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridedit")
	$vw_bill_ranap_detail_konsul_dokter_grid->RowIndex = 0;
while ($vw_bill_ranap_detail_konsul_dokter_grid->RecCnt < $vw_bill_ranap_detail_konsul_dokter_grid->StopRec) {
	$vw_bill_ranap_detail_konsul_dokter_grid->RecCnt++;
	if (intval($vw_bill_ranap_detail_konsul_dokter_grid->RecCnt) >= intval($vw_bill_ranap_detail_konsul_dokter_grid->StartRec)) {
		$vw_bill_ranap_detail_konsul_dokter_grid->RowCnt++;
		if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridadd" || $vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridedit" || $vw_bill_ranap_detail_konsul_dokter->CurrentAction == "F") {
			$vw_bill_ranap_detail_konsul_dokter_grid->RowIndex++;
			$objForm->Index = $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex;
			if ($objForm->HasValue($vw_bill_ranap_detail_konsul_dokter_grid->FormActionName))
				$vw_bill_ranap_detail_konsul_dokter_grid->RowAction = strval($objForm->GetValue($vw_bill_ranap_detail_konsul_dokter_grid->FormActionName));
			elseif ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridadd")
				$vw_bill_ranap_detail_konsul_dokter_grid->RowAction = "insert";
			else
				$vw_bill_ranap_detail_konsul_dokter_grid->RowAction = "";
		}

		// Set up key count
		$vw_bill_ranap_detail_konsul_dokter_grid->KeyCount = $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex;

		// Init row class and style
		$vw_bill_ranap_detail_konsul_dokter->ResetAttrs();
		$vw_bill_ranap_detail_konsul_dokter->CssClass = "";
		if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridadd") {
			if ($vw_bill_ranap_detail_konsul_dokter->CurrentMode == "copy") {
				$vw_bill_ranap_detail_konsul_dokter_grid->LoadRowValues($vw_bill_ranap_detail_konsul_dokter_grid->Recordset); // Load row values
				$vw_bill_ranap_detail_konsul_dokter_grid->SetRecordKey($vw_bill_ranap_detail_konsul_dokter_grid->RowOldKey, $vw_bill_ranap_detail_konsul_dokter_grid->Recordset); // Set old record key
			} else {
				$vw_bill_ranap_detail_konsul_dokter_grid->LoadDefaultValues(); // Load default values
				$vw_bill_ranap_detail_konsul_dokter_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$vw_bill_ranap_detail_konsul_dokter_grid->LoadRowValues($vw_bill_ranap_detail_konsul_dokter_grid->Recordset); // Load row values
		}
		$vw_bill_ranap_detail_konsul_dokter->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridadd") // Grid add
			$vw_bill_ranap_detail_konsul_dokter->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridadd" && $vw_bill_ranap_detail_konsul_dokter->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vw_bill_ranap_detail_konsul_dokter_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_konsul_dokter_grid->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridedit") { // Grid edit
			if ($vw_bill_ranap_detail_konsul_dokter->EventCancelled) {
				$vw_bill_ranap_detail_konsul_dokter_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_konsul_dokter_grid->RowIndex); // Restore form values
			}
			if ($vw_bill_ranap_detail_konsul_dokter_grid->RowAction == "insert")
				$vw_bill_ranap_detail_konsul_dokter->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vw_bill_ranap_detail_konsul_dokter->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "gridedit" && ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) && $vw_bill_ranap_detail_konsul_dokter->EventCancelled) // Update failed
			$vw_bill_ranap_detail_konsul_dokter_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_konsul_dokter_grid->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vw_bill_ranap_detail_konsul_dokter_grid->EditRowCnt++;
		if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction == "F") // Confirm row
			$vw_bill_ranap_detail_konsul_dokter_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_konsul_dokter_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$vw_bill_ranap_detail_konsul_dokter->RowAttrs = array_merge($vw_bill_ranap_detail_konsul_dokter->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_konsul_dokter_grid->RowCnt, 'id'=>'r' . $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt . '_vw_bill_ranap_detail_konsul_dokter', 'data-rowtype'=>$vw_bill_ranap_detail_konsul_dokter->RowType));

		// Render row
		$vw_bill_ranap_detail_konsul_dokter_grid->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_konsul_dokter_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vw_bill_ranap_detail_konsul_dokter_grid->RowAction <> "delete" && $vw_bill_ranap_detail_konsul_dokter_grid->RowAction <> "insertdelete" && !($vw_bill_ranap_detail_konsul_dokter_grid->RowAction == "insert" && $vw_bill_ranap_detail_konsul_dokter->CurrentAction == "F" && $vw_bill_ranap_detail_konsul_dokter_grid->EmptyRow())) {
?>
	<tr<?php echo $vw_bill_ranap_detail_konsul_dokter->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_konsul_dokter_grid->ListOptions->Render("body", "left", $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt);
?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal"<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_tanggal" class="form-group vw_bill_ranap_detail_konsul_dokter_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_konsul_dokter->tanggal->ReadOnly && !$vw_bill_ranap_detail_konsul_dokter->tanggal->Disabled && !isset($vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_konsul_doktergrid", "x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_tanggal" class="form-group vw_bill_ranap_detail_konsul_dokter_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_konsul_dokter->tanggal->ReadOnly && !$vw_bill_ranap_detail_konsul_dokter->tanggal->Disabled && !isset($vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_konsul_doktergrid", "x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_tanggal" class="vw_bill_ranap_detail_konsul_dokter_tanggal">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" name="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" name="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->PageObjName . "_row_" . $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->id->CurrentValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_id" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_id" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->id->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_konsul_dokter->CurrentMode == "edit") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan"<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_kode_tindakan" class="form-group vw_bill_ranap_detail_konsul_dokter_kode_tindakan">
<?php $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif">
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_kode_tindakan" class="form-group vw_bill_ranap_detail_konsul_dokter_kode_tindakan">
<?php $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif">
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_kode_tindakan" class="vw_bill_ranap_detail_konsul_dokter_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" name="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" name="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->kode_dokter->Visible) { // kode_dokter ?>
		<td data-name="kode_dokter"<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_kode_dokter" class="form-group vw_bill_ranap_detail_konsul_dokter_kode_dokter">
<select data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" data-value-separator="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter"<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_dokter->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_kode_dokter" class="form-group vw_bill_ranap_detail_konsul_dokter_kode_dokter">
<select data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" data-value-separator="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter"<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_kode_dokter" class="vw_bill_ranap_detail_konsul_dokter_kode_dokter">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_dokter->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_dokter->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" name="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_dokter->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" name="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_dokter->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->qty->Visible) { // qty ?>
		<td data-name="qty"<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_qty" class="form-group vw_bill_ranap_detail_konsul_dokter_qty">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_qty" class="form-group vw_bill_ranap_detail_konsul_dokter_qty">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_qty" class="vw_bill_ranap_detail_konsul_dokter_qty">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->tarif->Visible) { // tarif ?>
		<td data-name="tarif"<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_tarif" class="form-group vw_bill_ranap_detail_konsul_dokter_tarif">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_tarif" class="form-group vw_bill_ranap_detail_konsul_dokter_tarif">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_tarif" class="vw_bill_ranap_detail_konsul_dokter_tarif">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->user->Visible) { // user ?>
		<td data-name="user"<?php echo $vw_bill_ranap_detail_konsul_dokter->user->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_user" class="form-group vw_bill_ranap_detail_konsul_dokter_user">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" size="1" maxlength="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->user->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_user" class="form-group vw_bill_ranap_detail_konsul_dokter_user">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" size="1" maxlength="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->user->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_user" class="vw_bill_ranap_detail_konsul_dokter_user">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->user->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->user->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->no_ruang->Visible) { // no_ruang ?>
		<td data-name="no_ruang"<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->no_ruang->getSessionValue() <> "") { ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="form-group vw_bill_ranap_detail_konsul_dokter_no_ruang">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="form-group vw_bill_ranap_detail_konsul_dokter_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->no_ruang->getSessionValue() <> "") { ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="form-group vw_bill_ranap_detail_konsul_dokter_no_ruang">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="form-group vw_bill_ranap_detail_konsul_dokter_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt ?>_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="vw_bill_ranap_detail_konsul_dokter_no_ruang">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="fvw_bill_ranap_detail_konsul_doktergrid$x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="fvw_bill_ranap_detail_konsul_doktergrid$o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_konsul_dokter_grid->ListOptions->Render("body", "right", $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt);
?>
	</tr>
<?php if ($vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_ADD || $vw_bill_ranap_detail_konsul_dokter->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_konsul_doktergrid.UpdateOpts(<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "gridadd" || $vw_bill_ranap_detail_konsul_dokter->CurrentMode == "copy")
		if (!$vw_bill_ranap_detail_konsul_dokter_grid->Recordset->EOF) $vw_bill_ranap_detail_konsul_dokter_grid->Recordset->MoveNext();
}
?>
<?php
	if ($vw_bill_ranap_detail_konsul_dokter->CurrentMode == "add" || $vw_bill_ranap_detail_konsul_dokter->CurrentMode == "copy" || $vw_bill_ranap_detail_konsul_dokter->CurrentMode == "edit") {
		$vw_bill_ranap_detail_konsul_dokter_grid->RowIndex = '$rowindex$';
		$vw_bill_ranap_detail_konsul_dokter_grid->LoadDefaultValues();

		// Set row properties
		$vw_bill_ranap_detail_konsul_dokter->ResetAttrs();
		$vw_bill_ranap_detail_konsul_dokter->RowAttrs = array_merge($vw_bill_ranap_detail_konsul_dokter->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_konsul_dokter_grid->RowIndex, 'id'=>'r0_vw_bill_ranap_detail_konsul_dokter', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($vw_bill_ranap_detail_konsul_dokter->RowAttrs["class"], "ewTemplate");
		$vw_bill_ranap_detail_konsul_dokter->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vw_bill_ranap_detail_konsul_dokter_grid->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_konsul_dokter_grid->RenderListOptions();
		$vw_bill_ranap_detail_konsul_dokter_grid->StartRowCnt = 0;
?>
	<tr<?php echo $vw_bill_ranap_detail_konsul_dokter->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_konsul_dokter_grid->ListOptions->Render("body", "left", $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex);
?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal">
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_tanggal" class="form-group vw_bill_ranap_detail_konsul_dokter_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_konsul_dokter->tanggal->ReadOnly && !$vw_bill_ranap_detail_konsul_dokter->tanggal->Disabled && !isset($vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_konsul_dokter->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_konsul_doktergrid", "x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_tanggal" class="form-group vw_bill_ranap_detail_konsul_dokter_tanggal">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->tanggal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tanggal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan">
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_kode_tindakan" class="form-group vw_bill_ranap_detail_konsul_dokter_kode_tindakan">
<?php $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif">
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_kode_tindakan" class="form-group vw_bill_ranap_detail_konsul_dokter_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->kode_tindakan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_tindakan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->kode_dokter->Visible) { // kode_dokter ?>
		<td data-name="kode_dokter">
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_kode_dokter" class="form-group vw_bill_ranap_detail_konsul_dokter_kode_dokter">
<select data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" data-value-separator="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter"<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="s_x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_kode_dokter" class="form-group vw_bill_ranap_detail_konsul_dokter_kode_dokter">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->kode_dokter->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_dokter->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_kode_dokter" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_kode_dokter" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->kode_dokter->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->qty->Visible) { // qty ?>
		<td data-name="qty">
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_qty" class="form-group vw_bill_ranap_detail_konsul_dokter_qty">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_qty" class="form-group vw_bill_ranap_detail_konsul_dokter_qty">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->qty->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->qty->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->qty->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->tarif->Visible) { // tarif ?>
		<td data-name="tarif">
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_tarif" class="form-group vw_bill_ranap_detail_konsul_dokter_tarif">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_tarif" class="form-group vw_bill_ranap_detail_konsul_dokter_tarif">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->tarif->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->tarif->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->user->Visible) { // user ?>
		<td data-name="user">
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_user" class="form-group vw_bill_ranap_detail_konsul_dokter_user">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" size="1" maxlength="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->user->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_user" class="form-group vw_bill_ranap_detail_konsul_dokter_user">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->user->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->user->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->user->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_konsul_dokter->no_ruang->Visible) { // no_ruang ?>
		<td data-name="no_ruang">
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentAction <> "F") { ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->no_ruang->getSessionValue() <> "") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="form-group vw_bill_ranap_detail_konsul_dokter_no_ruang">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="form-group vw_bill_ranap_detail_konsul_dokter_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_konsul_dokter_no_ruang" class="form-group vw_bill_ranap_detail_konsul_dokter_no_ruang">
<span<?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_konsul_dokter->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_konsul_dokter" data-field="x_no_ruang" name="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" id="o<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_konsul_dokter->no_ruang->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_konsul_dokter_grid->ListOptions->Render("body", "right", $vw_bill_ranap_detail_konsul_dokter_grid->RowCnt);
?>
<script type="text/javascript">
fvw_bill_ranap_detail_konsul_doktergrid.UpdateOpts(<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentMode == "add" || $vw_bill_ranap_detail_konsul_dokter->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_konsul_dokter_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvw_bill_ranap_detail_konsul_doktergrid">
</div>
<?php

// Close recordset
if ($vw_bill_ranap_detail_konsul_dokter_grid->Recordset)
	$vw_bill_ranap_detail_konsul_dokter_grid->Recordset->Close();
?>
<?php if ($vw_bill_ranap_detail_konsul_dokter_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($vw_bill_ranap_detail_konsul_dokter_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter_grid->TotalRecs == 0 && $vw_bill_ranap_detail_konsul_dokter->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_detail_konsul_dokter_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_dokter->Export == "") { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_konsul_doktergrid.Init();
</script>
<?php } ?>
<?php
$vw_bill_ranap_detail_konsul_dokter_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$vw_bill_ranap_detail_konsul_dokter_grid->Page_Terminate();
?>
